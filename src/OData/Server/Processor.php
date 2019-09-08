<?php

namespace OData\Server;

use OData\Handlers\CRUDHandler;
use OData\Server\Context\Request;
use OData\Server\Context\Response;

/**
 * Class Processor
 *
 *
 * @package OData\Server
 */
class Processor
{
    /** @var Request $request */
    private $request;
    /** @var Response $response */
    private $response;

    /**
     * Handler constructor.
     * Дело в том, что мы хотим добиться возможности запускать обработчик как через cli так и через cgi
     * плюс ко всему мы можем генерировать тест кейсы, формирую заранее запросы и ответы
     *
     * @param Request  $request
     * @param Response $response
     */
    public function __construct(Request &$request, Response &$response) {
        $this->request = $request;
        $this->response = $response;

        $this->process();
    }

    /**
     * Здесь мы обрабатываем данные и формируем запрос и ответ
     */
    private function process(): void {
        new CRUDHandler($this->request, $this->response);
    }
}