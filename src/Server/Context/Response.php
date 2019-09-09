<?php

namespace Falseclock\OData\Server\Context;

class Response
{
    /** @var string $payLoad */
    private $payLoad;
    /** @var Header[] $headers */
    private $headers;
    /** @var int $status */
    private $status;

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
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function __construct()
    {
        $this->headers[] = new Header("OData-Version", "4.0");
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

    public function setContentType(string $contentType)
    {
        $this->headers[] = new Header("Content-Type", $contentType);
    }
}