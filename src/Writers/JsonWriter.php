<?php

namespace Falseclock\OData\Writers;

use Exception;
use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Join;
use Falseclock\OData\Edm\EdmEntity;
use Falseclock\OData\Server\Configuration;
use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;
use Falseclock\OData\Specification\Constants;

class JsonWriter extends BaseWriter
{
	public  $writer;
	private $request;
	private $response;

	public function __construct(Request &$request, Response &$response) {
		parent::__construct($request, $response);

		$response->setContentType("application/json; charset=UTF-8; metadata={$request->getMetadata()}");

		$this->request = $request;
		$this->response = $response;
	}

	public function getStringOutput() {
		return json_encode($this->writer, JSON_UNESCAPED_UNICODE);
	}

	public function getWriter() {
		return $this->writer;
	}

	/**
	 * @return $this|Writer
	 * @throws Exception
	 */
	public function metadata() {

		$this->writer['$' . Constants::EDMX_VERSION] = Constants::JSON_CSDL_VERSION;
		$this->writer['$' . Constants::REFERENCE] = (object) [
			Constants::REFERENCE_CORE_URI => (object) [
				'$' . Constants::INCLUDE => [
					(object) [
						'$' . Constants::NAMESPACE => Constants::CORE_NAMESPACE,
						'$' . Constants::ALIAS     => Constants::CORE_ALIAS,
					]
				]
			]
		];

		$entities = [];
		foreach($this->edmProvider->getEntities() as $entity) {

			$entityName = $entity->getName();

			$entities[$entityName] = [ '$' . Constants::KIND => Constants::ENTITY_TYPE ];

			// Write keys
			$keys = [];
			foreach($entity->getColumns() as $propertyName => $property) {
				if(isset($property->key) and $property->key == true) {
					$keys[] = $propertyName;
				}
			}

			$entities[$entityName] = array_merge($entities[$entityName], [ '$' . Constants::KEY => $keys ]);

			foreach($entity->getColumns() as $columnName => $property) {
				$entities = $this->writeEntityProperties($property, $entities, $entity, $columnName);
			}

			$annotation = $entity->getAnnotation();
			if(!empty($annotation)) {
				$entities[$entityName] = array_merge($entities[$entityName], [ '@' . Constants::CORE_ANNOTATION_TERM => $annotation ]);
			}

			foreach($entity->getConstraints() as $constraintName => $constraintValue) {
				$reference = [];
				$reference['$' . Constants::KIND] = Constants::NAVIGATION_PROPERTY;

				switch($constraintValue->join) {
					case Join::MANY_TO_MANY:
					case Join::ONE_TO_MANY:
						$reference['$' . Constants::PROPERTY_TYPE] = sprintf("Collection(%s.%s)", Configuration::me()->getNameSpace(), $constraintName);
						$reference['$' . Constants::COLLECTION] = true;
						$reference['$' . Constants::PROPERTY_PARTNER] = $entityName;
						break;
					default:
						$reference['$' . Constants::PROPERTY_TYPE] = sprintf("%s.%s", Configuration::me()->getNameSpace(), $constraintName);
				}

				$localColumn = $entity->getColumnByOriginName($constraintValue->localTable, $constraintValue->localColumn->name);
				$foreignColumn = $entity->getColumnByOriginName($constraintValue->foreignTable, $constraintValue->foreignColumn->name);

				$reference['$' . Constants::REFERENTIAL_CONSTRAINT] = [ $localColumn => $foreignColumn ];

				$entities[$entityName] = array_merge($entities[$entityName], [ $constraintName => $reference ]);
			}

			foreach($entity->getComplexes() as $complexName => $complexValue) {

				$complex = [];

				$complex['$' . Constants::KIND] = Constants::COMPLEX_TYPE;

				foreach($entity->getColumns() as $propertyName => $property) {
					unset($property->defaultValue);
					$entities = $this->writeEntityProperties($property, $entities, $entity, $propertyName);
				}
			}
		}

		$this->writer[Configuration::me()->getNameSpace()] = (object) $entities;

		return $this;
	}

	/**
	 * @return $this
	 * @throws Exception
	 */
	public function serviceDocument() {
		if($this->request->getMetadata() != 'none') {
			$this->writer['@' . Constants::METADATA_NAMESPACE_CONTEXT] = $this->getBaseUrl() . Constants::METADATA;
		}
		$this->writer['value'] = [];
		foreach($this->getEntities() as $entity) {
			$this->writer['value'][] = [ 'name' => $entity->getName(), 'url' => $entity->getName() ];
		}

		return $this;
	}

	/**
	 * @param Column    $property
	 * @param array     $entities
	 * @param EdmEntity $entity
	 * @param string    $columnName
	 *
	 * @return array
	 */
	private function writeEntityProperties(Column $property, array $entities, EdmEntity $entity, string $columnName): array {
		$column = [];
		$column['$' . Constants::PROPERTY_TYPE] = Constants::PROPERTY_TYPE_PREFIX . $property->type->getValue();
		if(isset($property->defaultValue))
			$column['$' . Constants::DEFAULT_VALUE] = $property->defaultValue;

		if(isset($property->maxLength))
			$column['$' . Constants::MAX_LENGTH] = $property->maxLength;

		if(is_bool($property->nullable))
			$column['$' . Constants::NULLABLE] = $property->nullable ? 'true' : 'false';

		if(isset($property->scale))
			$column['$' . Constants::SCALE] = $property->scale;

		if(isset($property->precision))
			$column['$' . Constants::PRECISION] = $property->precision;

		if(isset($property->annotation))
			$column['@' . Constants::CORE_ANNOTATION_TERM . '#'] = $property->annotation;

		$entities[$entity->getName()] = array_merge($entities[$entity->getName()], [ $columnName => $column ]);

		return $entities;
	}
}