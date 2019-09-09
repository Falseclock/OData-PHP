<?php

namespace Falseclock\OData\Helpers;

use Exception;
use Falseclock\OData\Server\Configuration;
use Falseclock\OData\Server\Context\Header;
use Falseclock\OData\Server\Context\Parameter;
use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Specification\Method;
use Falseclock\OData\Specification\Query;
use ReflectionClass;
use ReflectionException;

class RequestParser
{
    /** @var Request $request */
    private static $request;

    /**
     * Used for taking headers from CGI handler
     *
     * @return Request
     * @throws Exception
     */
    public static function cgi(): Request
    {

        self::$request = new Request();

        self::readHeaders();
        self::readUrl();
        self::readPath();
        self::readParams();
        self::readMethod();
        self::readPayload();

        return self::$request;
    }

    /**
     * Reads headers from
     */
    private static function readHeaders(): void
    {
        $headers = [];
        $copy_server = [
            'CONTENT_TYPE' => 'Content-Type',
            'CONTENT_LENGTH' => 'Content-Length',
            'CONTENT_MD5' => 'Content-Md5',
        ];
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) === 'HTTP_') {
                $key = substr($key, 5);
                if (!isset($copy_server[$key]) || !isset($_SERVER[$key])) {
                    $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $key))));
                    $headers[] = new Header($key, $value);
                }
            } else if (isset($copy_server[$key])) {
                $headers[] = new Header($copy_server[$key], $value);
            }
        }
        if (!isset($headers['Authorization'])) {
            if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                $headers[] = new Header('Authorization', $_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
            } else if (isset($_SERVER['PHP_AUTH_USER'])) {
                $basic_pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
                $headers[] = new Header('Authorization', 'Basic ' . base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $basic_pass));
            } else if (isset($_SERVER['PHP_AUTH_DIGEST'])) {
                $headers[] = new Header('Authorization', $_SERVER['PHP_AUTH_DIGEST']);
            }
        }

        self::$request->setHeaders($headers);
    }

    /**
     * @throws Exception
     */
    private static function readUrl(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        if (mb_strpos($requestUri, Configuration::me()->getContextPath()) == 0) {
            $requestUri = mb_substr($requestUri, mb_strlen(Configuration::me()->getContextPath()));
        } else {
            throw new Exception("Context path not found");
        }

        self::$request->setUrl($requestUri);
    }

    private static function readPath(): void
    {
        $parse = (object)parse_url(self::$request->getUrl());

        self::$request->setPath(isset($parse->path) ? $parse->path : "");
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    private static function readParams(): void
    {
        $parameters = [];

        $parse = (object)parse_url(self::$request->getUrl());
        if (isset($parse->query)) {

            parse_str($parse->query, $queryParams);

            $queryClass = new ReflectionClass(Query::class);
            $specificationParams = array_flip($queryClass->getConstants());

            foreach ($queryParams as $type => $value) {
                if (!isset($specificationParams[$type])) {
                    throw new Exception("Unsupported query params");
                }
                if ($type == Query::FORMAT) {
                    $array = explode(";", $value);
                    switch (mb_strtolower(trim($array[0]))) {
                        case "application/atomsvc+xml":
                        case "application/atom+xml":
                        case "application/xml":
                        case "xml":
                            self::$request->setFormat(Request::FORMAT_XML);
                            break;

                        case "application/json":
                        case "json":
                            self::$request->setFormat(Request::FORMAT_JSON);
                            if (isset($array[1])) {
                                if (preg_match("/.*?(metadata)=(.*)/", $array[1], $matches)) {
                                    $metadata = strtolower($matches[2]);
                                    if (in_array($metadata, ['minimal', 'full', 'none'])) {
                                        self::$request->setMetadata($metadata);
                                    } else {
                                        throw new Exception("Unsupported media type requested.");
                                    }
                                }
                            }
                            break;
                        default:
                            throw new Exception("Unsupported media type requested.");
                    }
                }
                $parameters[] = new Parameter($type, $value);
            }
        }
        // If no format defined still, get it from Accept header
        if (self::$request->getFormat() == null) {
            self::$request->setFormat(self::getAcceptFormat(self::$request));
        }

        self::$request->setParams($parameters);
    }

    public static function getAcceptFormat(Request $request)
    {
        foreach ($request->getHeaders() as $header) {
            if ($header->name == "Accept") {
                $accepts = explode(",", $header->value);
                foreach ($accepts as $accept) {
                    $type = explode(";", $accept);
                    switch (trim(strtolower($type[0]))) {
                        case "application/xml":
                            return Request::FORMAT_XML;
                            break;
                        case "application/json":
                            return Request::FORMAT_JSON;
                            break;
                    }
                }
            }
        }
        return Request::FORMAT_XML;
    }

    /**
     * @throws Exception
     */
    private static function readMethod()
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD']);

        $className = Method::class;

        if (!defined("$className::$method")) {
            throw new Exception("Unknown OData HTTP Method `$method`");
        }
        self::$request->setMethod($method);
    }

    /**
     * @throws Exception
     */
    private static function readPayload()
    {

        $contentLength = floatval($_SERVER['CONTENT_LENGTH']);

        if (in_array(self::$request->getMethod(), [Method::PATCH, Method::POST, Method::PUT])) {

            if ($contentLength) {

                $payload = file_get_contents('php://input');

                if (mb_strlen($payload) != $contentLength) {
                    throw new Exception("Payload length not equal to header length");
                }

                self::$request->setPayLoad($payload);
            } else {
                throw new Exception("No payload provided");
            }
        }
    }
}