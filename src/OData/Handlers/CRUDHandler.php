<?php

namespace Falseclock\OData\Handlers;

use Exception;
use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;
use Falseclock\OData\Specification\Method;

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