<?php

namespace Falseclock\OData\Writers;

use Exception;
use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Common\EntityException;
use Falseclock\DBD\Entity\Join;
use Falseclock\OData\Edm\EdmEntity;
use Falseclock\OData\Server\Configuration;
use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;
use Falseclock\OData\Specification\Constants;
use XMLWriter;

class AtomWriter extends BaseWriter
{
	/** @var XMLWriter Writer to which output (CSDL Document) is sent */
	public $xmlWriter;
	/** @var EdmEntity[] $entities */
	private $entities          = [];
	private $complexProperties = [];

	public function __construct(/** @noinspection PhpUnusedParameterInspection */ Request &$request, Response &$response) {
		$response->setContentType("application/xml; charset=UTF-8");

		$this->xmlWriter = new XMLWriter();
		$this->xmlWriter->openMemory();
		$this->xmlWriter->startDocument('1.0', 'UTF-8', 'yes');
		$this->xmlWriter->setIndent(4);
	}

	public function getStringOutput() {
		$this->xmlWriter->endDocument();

		return $this->xmlWriter->outputMemory(true);
	}

	/**
	 * @return XMLWriter
	 */
	public function getWriter() {
		return $this->xmlWriter;
	}

	/**
	 * @return $this|Writer
	 * @throws Exception
	 */
	public function metadata() {

		$this->entities = $this->getEntities();

		$this->xmlWriter->startElementNs(Constants::EDMX_NAMESPACE_PREFIX, Constants::EDMX_ELEMENT, Constants::EDMX_NAMESPACE);
		$this->xmlWriter->writeAttribute(Constants::XMLNS_NAMESPACE_PREFIX, Constants::EDM_NAMESPACE);
		$this->xmlWriter->writeAttribute(Constants::EDMX_VERSION, Constants::EDMX_VERSION_VALUE);

		/*
<edmx:Reference Uri="https://oasis-tcs.github.io/odata-vocabularies/vocabularies/Org.OData.Core.V1.xml">

    <edmx:Include Namespace="Org.OData.Core.V1" Alias="Core">

      <Annotation Term="Core.DefaultNamespace" />

    </edmx:Include>

  </edmx:Reference>
				 */

		$this->xmlWriter->startElementNs(Constants::EDMX_NAMESPACE_PREFIX, Constants::REFERENCE, Constants::REFERENCE_CORE_URI);
		$this->xmlWriter->startElementNs(Constants::EDMX_NAMESPACE_PREFIX, Constants::INCLUDE, null);
		$this->xmlWriter->writeAttribute(Constants::NAMESPACE, Constants::CORE_NAMESPACE);
		$this->xmlWriter->writeAttribute(Constants::ALIAS, Constants::CORE_ALIAS);

		$this->xmlWriter->startElement(Constants::ANNOTATION);
		$this->xmlWriter->writeAttribute(Constants::TERM, Constants::CORE_REFERENCE_ANNOTATION_TERM);
		$this->xmlWriter->endElement();

		$this->xmlWriter->endElement();
		$this->xmlWriter->endElement();

		/**  <edmx:DataServices> */
		$this->xmlWriter->startElementNs(Constants::EDMX_NAMESPACE_PREFIX, Constants::EDMX_DATASERVICES_ELEMENT, null);

		/** <Schema xmlns="http://docs.oasis-open.org/odata/ns/edm" Namespace="some.name.space"> */
		$this->xmlWriter->startElementNs(null, Constants::SCHEMA, Constants::EDM_NAMESPACE);
		$this->xmlWriter->writeAttribute(Constants::NAMESPACE, Configuration::me()->getNameSpace());

		foreach($this->entities as $entity) {
			/** <EntityType Name="EntityName" /> */
			$this->xmlWriter->startElement(Constants::ENTITY_TYPE);
			$this->xmlWriter->writeAttribute(Constants::NAME, $entity->getName());

			// Write keys
			$keys = [];
			foreach($entity->getColumns() as $propertyName => $property) {
				if(isset($property->key) and $property->key == true) {
					$keys[] = $propertyName;
				}
			}

			$this->xmlWriter->startElement(Constants::KEY);
			foreach($keys as $key) {
				$this->xmlWriter->startElement(Constants::PROPERTY_REF);
				$this->xmlWriter->writeAttribute(Constants::NAME, $key);
				$this->xmlWriter->endElement();
			}
			$this->xmlWriter->endElement();

			//process common fields

			foreach($entity->getColumns() as $propertyName => $property) {
				$this->writeEntityProperties($propertyName, $property);
			}

			foreach($entity->getConstraints() as $constraintName => $constraintValue) {

				/** NavigationProperty  */
				$this->xmlWriter->startElement(Constants::NAVIGATION_PROPERTY);
				$this->xmlWriter->writeAttribute(Constants::PROPERTY_NAME, $constraintName);

				switch($constraintValue->join) {
					case Join::MANY_TO_MANY:
					case Join::ONE_TO_MANY:
						$partner = $entity->getName();
						$type = sprintf("Collection(%s.%s)", Configuration::me()->getNameSpace(), $constraintName);
						break;
					default:
						$partner = null;
						$type = sprintf("%s.%s", Configuration::me()->getNameSpace(), $constraintName);
				}
				$this->xmlWriter->writeAttribute(Constants::PROPERTY_TYPE, $type);

				if(isset($partner)) {
					$this->xmlWriter->writeAttribute(Constants::PROPERTY_PARTNER, $partner);
				}

				/** ReferentialConstraint */
				$this->xmlWriter->startElement(Constants::REFERENTIAL_CONSTRAINT);

				$localColumn = $entity->getColumnByOriginName($constraintValue->localTable, $constraintValue->localColumn->name);
				$this->xmlWriter->writeAttribute(Constants::PROPERTY, $localColumn); // Local table column name

				$foreignColumn = $entity->getColumnByOriginName($constraintValue->foreignTable, $constraintValue->foreignColumn->name);
				$this->xmlWriter->writeAttribute(Constants::REFERENCED_PROPERTY, $foreignColumn); // Foreign table column name

				/** ReferentialConstraint */
				$this->xmlWriter->endElement();

				/** NavigationProperty  */
				$this->xmlWriter->endElement();
			}

			foreach($entity->getComplexes() as $complexName => $complexValue) {

				$this->complexProperties[$complexValue->typeClass] = $complexValue;

				$typeClass = substr($complexValue->typeClass, strrpos($complexValue->typeClass, '\\') + 1);

				if($complexValue->isIterable) {
					$typeClass = sprintf("Collection(%s.%s)", Configuration::me()->getNameSpace(), $typeClass);
				}
				else {
					$typeClass = sprintf("%s.%s", Configuration::me()->getNameSpace(), $typeClass);
				}

				$this->xmlWriter->startElement(Constants::PROPERTY);
				$this->xmlWriter->writeAttribute(Constants::PROPERTY_NAME, $complexName);
				$this->xmlWriter->writeAttribute(Constants::PROPERTY_TYPE, $typeClass);
				if($complexValue->nullable === false) {
					$this->xmlWriter->writeAttribute(Constants::NULLABLE, "false");
				}
				$this->xmlWriter->endElement();
			}

			$annotation = $entity->getAnnotation();
			if(!empty($annotation)) {
				$this->xmlWriter->startElement(Constants::ANNOTATION);
				$this->xmlWriter->writeAttribute(Constants::TERM, Constants::CORE_ANNOTATION_TERM);

				$this->xmlWriter->startElement(Constants::STRING);
				$this->xmlWriter->text(htmlspecialchars($annotation, ENT_XML1));
				$this->xmlWriter->endElement();

				$this->xmlWriter->endElement();
			}

			/** </EntityType> */
			$this->xmlWriter->endElement();
		}

		foreach($this->complexProperties as $complexName => $complexValue) {
			$entity = $this->getEntityByClass($complexName);

			$this->xmlWriter->startElement(Constants::COMPLEX_TYPE);
			$this->xmlWriter->writeAttribute(Constants::NAME, substr($complexValue->typeClass, strrpos($complexValue->typeClass, '\\') + 1));

			foreach($entity->getColumns() as $propertyName => $property) {
				unset($property->defaultValue);
				$this->writeEntityProperties($propertyName, $property);
			}

			$this->xmlWriter->endElement();
		}

		/** </Schema> */
		$this->xmlWriter->endElement();

		/* </edmx:DataServices> */
		$this->xmlWriter->endElement();

		return $this;
	}

	/**
	 * @throws Exception
	 */
	public function serviceDocument() {
		$this->xmlWriter->startElementNs(Constants::APP_NAMESPACE_PREFIX, Constants::ATOM_PUBLISHING_SERVICE_ELEMENT_NAME, Constants::APP_NAMESPACE);
		$this->xmlWriter->writeAttributeNs(Constants::XMLNS_NAMESPACE_PREFIX, Constants::ATOM_NAMESPACE_PREFIX, null, Constants::ATOM_NAMESPACE);
		$this->xmlWriter->writeAttributeNs(Constants::XMLNS_NAMESPACE_PREFIX, Constants::METADATA_NAMESPACE_PREFIX, null, Constants::METADATA_NAMESPACE);
		$this->xmlWriter->writeAttributeNs(Constants::XML_NAMESPACE_PREFIX, Constants::XML_BASE_ATTRIBUTE_NAME, null, $this->getBaseUrl());
		$this->xmlWriter->writeAttributeNs(Constants::METADATA_NAMESPACE_PREFIX, Constants::METADATA_NAMESPACE_CONTEXT, null, $this->getBaseUrl() . Constants::METADATA);

		$this->xmlWriter->startElementNs(Constants::APP_NAMESPACE_PREFIX, Constants::ATOM_PUBLISHING_WORKSPACE_ELEMNT_NAME, null);
		$this->xmlWriter->startElementNs(Constants::ATOM_NAMESPACE_PREFIX, Constants::ATOM_TITLE_ELEMENT_NAME, null);
		$this->xmlWriter->text(Configuration::me()->getNameSpace());
		$this->xmlWriter->endElement();

		foreach($this->getEntities() as $entity) {
			//start collection node
			$this->xmlWriter->startElementNs(Constants::APP_NAMESPACE_PREFIX, Constants::ATOM_PUBLISHING_COLLECTION_ELEMENT_NAME, null);
			$this->xmlWriter->writeAttribute(Constants::ATOM_HREF_ATTRIBUTE_NAME, $entity->getName());
			$this->xmlWriter->writeAttributeNs(Constants::METADATA_NAMESPACE_PREFIX, Constants::METADATA_NAMESPACE_NAME, null, $entity->getName());
			//start title node
			$this->xmlWriter->startElementNs(Constants::ATOM_NAMESPACE_PREFIX, Constants::ATOM_TITLE_ELEMENT_NAME, null);
			$this->xmlWriter->text($entity->getName());
			//end title node
			$this->xmlWriter->endElement();
			//end collection node
			$this->xmlWriter->endElement();
		}

		$this->xmlWriter->startElementNs(Constants::METADATA_NAMESPACE_PREFIX, Constants::SERVICE_DOCUMENT, null);
		$this->xmlWriter->writeAttribute(Constants::ATOM_HREF_ATTRIBUTE_NAME, Constants::REFERENCE_CORE_URI);

		$this->xmlWriter->startElementNs(Constants::ATOM_NAMESPACE_PREFIX, Constants::ATOM_TITLE_ELEMENT_NAME, null);
		$this->xmlWriter->text(Constants::CORE_NAMESPACE);
		$this->xmlWriter->endElement();
		$this->xmlWriter->endElement();

		//End workspace and service nodes
		$this->xmlWriter->endElement();
		$this->xmlWriter->endElement();

		return $this;
	}

	/**
	 * @param $className
	 *
	 * @return EdmEntity
	 * @throws EntityException
	 */
	private function getEntityByClass($className) {
		foreach($this->entities as $entity) {
			if($className == $entity->getClassName()) {
				return $entity;
			}
		}
		throw new EntityException("Can't find Entity by class name");
	}

	/**
	 * @param string $propertyName
	 * @param Column $property
	 */
	private function writeEntityProperties($propertyName, Column $property): void {

		$this->xmlWriter->startElement(Constants::PROPERTY);
		$this->xmlWriter->writeAttribute(Constants::PROPERTY_NAME, $propertyName);
		$this->xmlWriter->writeAttribute(Constants::PROPERTY_TYPE, Constants::PROPERTY_TYPE_PREFIX . $property->type->getValue());
		if(isset($property->defaultValue))
			$this->xmlWriter->writeAttribute(Constants::DEFAULT_VALUE, $property->defaultValue);

		if(isset($property->maxLength))
			$this->xmlWriter->writeAttribute(Constants::MAX_LENGTH, $property->maxLength);

		if(is_bool($property->nullable))
			$this->xmlWriter->writeAttribute(Constants::NULLABLE, ($property->nullable) ? 'true' : 'false');

		if(isset($property->scale))
			$this->xmlWriter->writeAttribute(Constants::SCALE, $property->scale);

		if(isset($property->precision))
			$this->xmlWriter->writeAttribute(Constants::PRECISION, $property->precision);

		if(isset($property->annotation)) {
			$this->xmlWriter->startElement(Constants::ANNOTATION);
			$this->xmlWriter->writeAttribute(Constants::TERM, Constants::CORE_ANNOTATION_TERM);

			$this->xmlWriter->startElement(Constants::STRING);
			$this->xmlWriter->text(htmlspecialchars($property->annotation, ENT_XML1));
			$this->xmlWriter->endElement();

			$this->xmlWriter->endElement();
		}

		$this->xmlWriter->endElement();
	}
}