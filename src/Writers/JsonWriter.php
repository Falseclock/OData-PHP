<?php

namespace Falseclock\OData\Writers;

use Exception;
use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;
use Falseclock\OData\Specification\Constants;

class JsonWriter extends BaseWriter
{
    public $writer;
    private $request;
    private $response;

    public function __construct(Request &$request, Response &$response)
    {
        $response->setContentType("application/json; charset=UTF-8; metadata={$request->getMetadata()}");

        $this->request = $request;
        $this->response = $response;
    }

    public function getStringOutput()
    {
        return json_encode($this->writer, JSON_UNESCAPED_UNICODE);
    }

    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function serviceDocument()
    {
        if ($this->request->getMetadata() != 'none') {
			$this->writer['@context'] = $this->getBaseUrl() . Constants::METADATA;
        }
        $this->writer['value'] = [];
        foreach ($this->getEntities() as $entity) {
            $this->writer['value'][] = ['name' => $entity->getName(), 'url' => $entity->getName()];
        }

        return $this;
    }

	public function metadata() {
		// TODO: Implement metadata() method.
	}
}