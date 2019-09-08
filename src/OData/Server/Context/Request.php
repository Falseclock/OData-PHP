<?php

namespace Falseclock\OData\Server\Context;

class Request
{
    const FORMAT_XML = "xml";
    const FORMAT_JSON = "json";

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
    /** @var string $format */
    private $format;
    /** @var string $metadata */
    private $metadata = "minimal";

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
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
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
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}