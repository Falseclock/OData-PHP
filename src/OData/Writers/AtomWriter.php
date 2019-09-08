<?php
/**
 * <description should be written here>
 *
 * @package      Falseclock\OData\Writers
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 *
 * @author       Written by Nurlan Mukhanov <nmukhanov@mp.kz>, сентябрь 2019
 */

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

    public function __construct(/** @noinspection PhpUnusedParameterInspection */ Request &$request, Response &$response)
    {
        $response->setContentType("application/xml; charset=UTF-8");

        $this->xmlWriter = new XMLWriter();
        $this->xmlWriter->openMemory();
        $this->xmlWriter->startDocument('1.0', 'UTF-8', 'yes');
        $this->xmlWriter->setIndent(4);
    }

    /**
     * @throws Exception
     */
    public function serviceDocument()
    {
        $this->xmlWriter = new XMLWriter();
        $this->xmlWriter->openMemory();
        $this->xmlWriter->startDocument('1.0', 'UTF-8');
        $this->xmlWriter->setIndent(4);

        $this->xmlWriter->startElementNs(Constants::APP_NAMESPACE_PREFIX, Constants::ATOM_PUBLISHING_SERVICE_ELEMENT_NAME, Constants::APP_NAMESPACE);
        $this->xmlWriter->writeAttributeNs(Constants::XMLNS_NAMESPACE_PREFIX, Constants::ATOM_NAMESPACE_PREFIX, null, Constants::ATOM_NAMESPACE);
        $this->xmlWriter->writeAttributeNs(Constants::XMLNS_NAMESPACE_PREFIX, Constants::METADATA_NAMESPACE_PREFIX, null, Constants::METADATA_NAMESPACE);
        $this->xmlWriter->writeAttributeNs(Constants::XML_NAMESPACE_PREFIX, Constants::XML_BASE_ATTRIBUTE_NAME, null, $this->getBaseUrl());
        $this->xmlWriter->writeAttributeNs(Constants::METADATA_NAMESPACE_PREFIX, Constants::METADATA_NAMESPACE_CONTEXT, null, $this->getBaseUrl() . '$metadata');

        $this->xmlWriter->startElementNs(Constants::APP_NAMESPACE_PREFIX, Constants::ATOM_PUBLISHING_WORKSPACE_ELEMNT_NAME, null);
        $this->xmlWriter->startElementNs(Constants::ATOM_NAMESPACE_PREFIX, Constants::ATOM_TITLE_ELEMENT_NAME, null);
        $this->xmlWriter->text(Configuration::me()->getNameSpace());
        $this->xmlWriter->endElement();

        foreach ($this->getEntities() as $entity) {
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

        //End workspace and service nodes
        $this->xmlWriter->endElement();
        $this->xmlWriter->endElement();

        return $this;
    }

    public function getStringOutput()
    {
        $this->xmlWriter->endDocument();
        return $this->xmlWriter->outputMemory(true);
    }

    /**
     * @return XMLWriter
     */
    public function getWriter()
    {
        return $this->xmlWriter;
    }
}