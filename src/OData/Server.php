<?php

namespace OData;

use OData\Helpers\RequestParser;
use OData\Server\Context\Response;
use OData\Server\Processor;

class Server
{
	private $request;
	private $response;

	public function __construct() {

	}

	/**
	 * @return Server\Context\Request
	 */
	public function getRequest(): Server\Context\Request {
		return $this->request;
	}

	/**
	 * @return Response
	 */
	public function getResponse(): Response {
		return $this->response;
	}

	public function process() {
		if(!isset($this->request)) {
			$this->request = RequestParser::cgi();
		}
		if(!isset($this->response)) {
			$this->response = new Response();
		}
		new Processor($this->request, $this->response);

		$foo = 1;
	}

	/**
	 * @param Server\Context\Request $request
	 */
	public function setRequest(Server\Context\Request $request): void {
		$this->request = $request;
	}

	/**
	 * @param Response $response
	 */
	public function setResponse(Response $response): void {
		$this->response = $response;
	}
}