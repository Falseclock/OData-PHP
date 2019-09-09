<?php

namespace Falseclock\OData;

use Exception;
use Falseclock\OData\Helpers\RequestParser;
use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;
use Falseclock\OData\Server\Processor;

class Server
{
    /** @var Request $request */
    private $request;
    /** @var Response $response */
    private $response;

    public function __construct()
    {

    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function out()
    {
        foreach ($this->response->getHeaders() as $header) {
            @header("{$header->name}: {$header->value}");
        }
        echo $this->getResponse()->getPayLoad();
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function process()
    {
        if (!isset($this->request) and PHP_SAPI !== 'cli') {
            $this->request = RequestParser::cgi();
        }
        if (!isset($this->response)) {
            $this->response = new Response();
        }
        new Processor($this->request, $this->response);

        return $this;
    }
}