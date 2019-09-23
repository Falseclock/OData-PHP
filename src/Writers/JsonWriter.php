<?php

namespace Falseclock\OData\Writers;

use Exception;
use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Common\EntityException;
use Falseclock\DBD\Entity\Join;
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

	/**
	 * @return self
	 */
	public function collection() {
		return $this;
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

		$nameSpace = Configuration::me()->getNameSpace();
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
				$columns = $this->writeEntityProperties($property);
				$entities[$entityName][$columnName] = $columns;
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
						$reference['$' . Constants::PROPERTY_TYPE] = sprintf("Collection(%s.%s)", $nameSpace, $constraintName);
						$reference['$' . Constants::COLLECTION] = true;
						$reference['$' . Constants::PROPERTY_PARTNER] = $entityName;
						break;
					default:
						$reference['$' . Constants::PROPERTY_TYPE] = sprintf("%s.%s", $nameSpace, $constraintName);
				}

				$localColumn = $entity->getColumnByOriginName($constraintValue->localTable, $constraintValue->localColumn->name);
				$foreignColumn = $entity->getColumnByOriginName($constraintValue->foreignTable, $constraintValue->foreignColumn->name);

				$reference['$' . Constants::REFERENTIAL_CONSTRAINT] = [ $localColumn => $foreignColumn ];

				$entities[$entityName] = array_merge($entities[$entityName], [ $constraintName => $reference ]);
			}

			foreach($this->edmProvider->getComplexes() as $complexName => $complexValue) {
				if(isset($this->edmProvider->getEntities()[$complexName])) {
					throw new EntityException("Class '{$complexName}' used somewhere for complex annotation. Please extend it with Row class implementation, 
				cause EntityType and ComplexType can't have the same name."
					);
				}
				// Define name of the complex
				$name = substr($complexName, strrpos($complexName, '\\') + 1);

				/** Let's build ift. We should get something like this
				 * "Categories": {
				 *   "$Kind":       "ComplexType",
				 *   "name":        {
				 *     "$Type":              "Edm.String",
				 *     "$MaxLength":         255,
				 *     "@Core.Description#": "Название категории"
				 *   },
				 *   "description": {
				 *     "$Type":              "Edm.String",
				 *     "$MaxLength":         255,
				 *     "@Core.Description#": "Дополнительная информация по категории"
				 *   },
				 *   "id":          {
				 *     "$Type":              "Edm.Int32",
				 *     "@Core.Description#": "Идентификатор категории, уникальный, серийный"
				 *   }
				 * }
				 */

				$complex = [];

				$complex['$' . Constants::KIND] = Constants::COMPLEX_TYPE;

				foreach($complexValue->getColumns() as $propertyName => $property) {
					unset($property->defaultValue);
					$complex[$propertyName] = $this->writeEntityProperties($property);
				}

				$entities[$name] = $complex;
			}
		}

		$container = Configuration::me()->getContainer();
		$entities[$container] = [ '$' . Constants::KIND => Constants::ENTITY_CONTAINER ];

		foreach($this->edmProvider->getEntities() as $entityClass => $entity) {
			$entities[$container][$entity->getName()] = [
				'$' . Constants::KIND          => Constants::ENTITY_SET,
				'$' . Constants::PROPERTY_TYPE => Configuration::me()->getNameSpace() . "." . $entity->getName()
			];
			$bindings = [];

			foreach($entity->getConstraints() as $constraintName => $constraintValue) {
				$target = substr($constraintValue->class, strrpos($constraintValue->class, '\\') + 1);
				$bindings[$constraintName] = $target;
			}

			if(count($bindings)) {
				$entities[$container][$entity->getName()]['$' . Constants::NAVIGATION_PROPERTY_BINDING] = $bindings;
			}
		}

		$this->writer[$nameSpace] = (object) $entities;

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
	 * @param Column $property
	 *
	 * @return array
	 */
	private function writeEntityProperties(Column $property): array {
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

		return $column;
		/*		$entities[$entity->getName()] = array_merge($entities[$entity->getName()], [ $columnName => $column ]);

				return $entities;*/
	}
}