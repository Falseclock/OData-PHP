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
use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;

class JsonWriter extends BaseWriter
{
    public $writer;
    private $request;
    private $response;

    public function __construct(Request &$request, Response &$response)
    {
        $response->setContentType("application/json; charset=UTF-8; metadata={$request->getMetadata()}");

        $this->request = $request;
        $this->response = $response;
    }

    public function getStringOutput()
    {
        return json_encode($this->writer, JSON_UNESCAPED_UNICODE);
    }

    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function serviceDocument()
    {
        if ($this->request->getMetadata() != 'none') {
            $this->writer['@context'] = $this->getBaseUrl() . '$metadata';
        }
        $this->writer['value'] = [];
        foreach ($this->getEntities() as $entity) {
            $this->writer['value'][] = ['name' => $entity->getName(), 'url' => $entity->getName()];
        }

        return $this;
    }
}