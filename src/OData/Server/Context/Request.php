<?php

namespace OData\Server\Context;

class Request
{
	/** @var string $method */
	private $method;
	/** @var Header[] $headers */
	private $headers;
	/** @var string $payLoad */
	private $payLoad;
	/** @var string */
	private $url;
	/** @var Parameter[] $params */
	private $params;
	/** @var string $path */
	private $path;

	/**
	 * @return Header[]
	 */
	public function getHeaders(): array {
		return $this->headers;
	}

	/**
	 * @return string
	 */
	public function getMethod(): string {
		return $this->method;
	}

	/**
	 * @return Parameter[]
	 */
	public function getParams(): array {
		return $this->params;
	}

	/**
	 * @return string
	 */
	public function getPath(): string {
		return $this->path;
	}

	/**
	 * @return string
	 */
	public function getPayLoad(): string {
		return $this->payLoad;
	}

	/**
	 * @return string
	 */
	public function getUrl(): string {
		return $this->url;
	}

	/**
	 * @param Header[] $headers
	 */
	public function setHeaders(array $headers): void {
		$this->headers = $headers;
	}

	/**
	 * @param string $method
	 */
	public function setMethod(string $method): void {
		$this->method = $method;
	}

	/**
	 * @param Parameter[] $params
	 */
	public function setParams(array $params): void {
		$this->params = $params;
	}

	/**
	 * @param string $path
	 */
	public function setPath(string $path): void {
		$this->path = $path;
	}

	/**
	 * @param string $payLoad
	 */
	public function setPayLoad(string $payLoad): void {
		$this->payLoad = $payLoad;
	}

	/**
	 * @param string $url
	 *
	 * @return void
	 */
	public function setUrl(string $url): void {
		$this->url = $url;
	}
}