<?php

namespace OData\Handlers;

use Exception;
use OData\Server\Context\Request;
use OData\Server\Context\Response;
use OData\Specification\Method;

class CRUDHandler
{
    /** @var Request $request */
    private $request;
    /** @var Response $response */
    private $response;

    /**
     * CRUDHandler constructor.
     *
     * @param Request $request
     * @param Response $response
     * @throws Exception
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;

        $this->handle();
    }

    /**
     * @throws Exception
     */
    private function handle(): void
    {
        switch ($this->request->getMethod()) {
            case Method::GET:
                new ReadHandler($this->request, $this->response);
        }
    }
}