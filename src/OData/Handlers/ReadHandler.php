<?php

namespace OData\Handlers;

use Exception;
use OData\Server\Configuration;
use OData\Server\Context\Request;
use OData\Server\Context\Response;
use OData\Specification\Constants;
use XMLWriter;

class ReadHandler
{

    /** @var Request $request */
    private $request;
    /** @var Response $response */
    private $response;
    /** @var Entity[] $entities */
    private $entities;
    /** @var XMLWriter */
    private $xmlWriter;

    /**
     * ReadHandler constructor.
     * @param Request $request
     * @param Response $response
     * @throws Exception
     */
    public function __construct(Request &$request, Response &$response)
    {
        $this->request = $request;
        $this->response = $response;

        $entitiesProvider = new EntitiesProvider();

        $this->entities = $entitiesProvider->getEntities();

        $this->xmlWriter = new XMLWriter();
        $this->xmlWriter->openMemory();
        $this->xmlWriter->startDocument('1.0', 'UTF-8', 'yes');
        $this->xmlWriter->setIndent(4);

        $this->xmlWriter->startElementNs(null, Constants::ATOM_PUBLISHING_SERVICE_ELEMENT_NAME, Constants::APP_NAMESPACE);
        $this->xmlWriter->writeAttributeNs(Constants::XML_NAMESPACE_PREFIX, Constants::XML_BASE_ATTRIBUTE_NAME, null, $this->getBaseUrl());
        $this->xmlWriter->writeAttributeNs(Constants::XMLNS_NAMESPACE_PREFIX, Constants::ATOM_NAMESPACE_PREFIX, null, Constants::ATOM_NAMESPACE);
        $this->xmlWriter->writeAttributeNs(Constants::XMLNS_NAMESPACE_PREFIX, Constants::APP_NAMESPACE_PREFIX, null, Constants::APP_NAMESPACE);

        $this->xmlWriter->startElement(Constants::ATOM_PUBLISHING_WORKSPACE_ELEMNT_NAME);
        $this->xmlWriter->startElementNs(Constants::ATOM_NAMESPACE_PREFIX, Constants::ATOM_TITLE_ELELMET_NAME, null);
        $this->xmlWriter->text(Configuration::me()->getNameSpace());
        $this->xmlWriter->endElement();


        foreach ($this->entities as $entity) {
            //start collection node
            $this->xmlWriter->startElement(Constants::ATOM_PUBLISHING_COLLECTION_ELEMENT_NAME);
            $this->xmlWriter->writeAttribute(Constants::ATOM_HREF_ATTRIBUTE_NAME, $this->getBaseUrl() . $entity->getName());
            //start title node
            $this->xmlWriter->startElementNs(Constants::ATOM_NAMESPACE_PREFIX, Constants::ATOM_TITLE_ELELMET_NAME, null);
            $this->xmlWriter->text($entity->getName());
            //end title node
            $this->xmlWriter->endElement();
            //end collection node
            $this->xmlWriter->endElement();
        }


        //End workspace and service nodes
        $this->xmlWriter->endElement();
        $this->xmlWriter->endElement();

        $this->xmlWriter->endDocument();
        $test = $this->xmlWriter->outputMemory(true);

        @header("Content-type: text/xml; charset=UTF-8");
        echo($test);

        return;

    }

    /**
     * @return string
     * @throws Exception
     */
    private function getBaseUrl(): string
    {
        return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}" . Configuration::me()->getContextPath();
    }
}