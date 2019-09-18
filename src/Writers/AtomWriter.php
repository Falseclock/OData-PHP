<?php

namespace Falseclock\OData\Writers;

use Exception;
use Falseclock\OData\Server\Configuration;
use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;
use Falseclock\OData\Specification\Constants;
use XMLWriter;

class AtomWriter extends BaseWriter
{
	/** @var XMLWriter Writer to which output (CSDL Document) is sent */
	public $xmlWriter;

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

		foreach($this->getEntities() as $entity) {
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

			//process fields

			foreach($entity->getColumns() as $propertyName => $property) {
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

			foreach($entity->getConstraints() as $constraint) {
				$foo = 1;
				/*				dump($entity);
								exit;*/
			}

			$annotation = $entity->getAnnotation();
			if (!empty($annotation)) {
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
}