<?php

namespace Falseclock\OData\Writers;

use Exception;
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
		foreach($this->getEntities() as $entity) {
			$entities[$entity->getName()] = [ '$' . Constants::KIND => Constants::ENTITY_TYPE ];

			// Write keys
			$keys = [];
			foreach($entity->getColumns() as $propertyName => $property) {
				if(isset($property->key) and $property->key == true) {
					$keys[] = $propertyName;
				}
			}

			$entities[$entity->getName()] = array_merge($entities[$entity->getName()], [ '$' . Constants::KEY => $keys ]);

			foreach($entity->getColumns() as $columnName => $property) {
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
			}

			// "@Core.Description#": "Таблица валют"
			$annotation = $entity->getAnnotation();
			if(!empty($annotation)) {
				$entities[$entity->getName()] = array_merge($entities[$entity->getName()], [ '@' . Constants::CORE_ANNOTATION_TERM => $annotation ]);
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
}