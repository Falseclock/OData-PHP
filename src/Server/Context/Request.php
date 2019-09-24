<?php

namespace Falseclock\OData\Server\Context;

use Falseclock\OData\Common\Url;

class Request
{
    const FORMAT_XML = "xml";
    const FORMAT_JSON = "json";

    /** @var string $method */
    protected $method;
    /** @var Header[] $headers */
	protected $headers;
    /** @var string $payLoad */
	protected $payLoad;
    /** @var Url */
	public $url;
    /** @var Parameter[] $params */
	protected $params;
    /** @var string $format */
	protected $format;
    /** @var string $metadata */
	protected $metadata = "minimal";

    /**
     * @return string
     */
    public function getMetadata(): string
    {
        return $this->metadata;
    }

    /**
     * @param string $metadata
     */
    public function setMetadata(string $metadata): void
    {
        $this->metadata = $metadata;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    /**
     * @return Header[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param Header[] $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return Parameter[]
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param Parameter[] $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getPayLoad(): string
    {
        return $this->payLoad;
    }

    /**
     * @param string $payLoad
     */
    public function setPayLoad(string $payLoad): void
    {
        $this->payLoad = $payLoad;
    }

    /**
     * @return Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }

}