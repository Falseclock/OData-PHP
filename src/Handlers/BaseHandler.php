<?php

namespace Falseclock\OData\Edm;

use Exception;
use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;
use Falseclock\OData\Writers\AtomWriter;
use Falseclock\OData\Writers\BaseWriter;
use Falseclock\OData\Writers\JsonWriter;

abstract class BaseHandler
{
	/** @var Request $request */
	private $request;
	/** @var Response $response */
	private $response;
	/** @var BaseWriter $writer */
	private $writer;

	/**
	 * ReadHandler constructor.
	 *
	 * @param Request  $request
	 * @param Response $response
	 *
	 * @throws Exception
	 */
	public function __construct(Request &$request, Response &$response) {
		$this->request = $request;
		$this->response = $response;

		switch($this->request->getFormat()) {
			default:
			case Request::FORMAT_XML:
				$this->writer = new AtomWriter($this->request, $this->response);
				break;
			case Request::FORMAT_JSON:
				$this->writer = new JsonWriter($this->request, $this->response);
				break;
		}
		$this->parseRequest();
	}

	/**
	 * @throws Exception
	 */
	private function parseRequest() {
		if(empty($this->request->url->path)) {
			$this->response->setPayLoad($this->writer->serviceDocument()->getStringOutput());

			return;
		}
		//else if($this->request->url->path == Constants::METADATA) {
		$this->response->setPayLoad($this->writer->metadata()->getStringOutput());
		//}
	}
}