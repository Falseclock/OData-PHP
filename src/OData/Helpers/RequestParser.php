<?php

namespace OData\Helpers;

use Exception;
use OData\Server\Configuration;
use OData\Server\Context\Parameter;
use OData\Server\Context\Request;
use OData\Specification\Method;
use OData\Specification\Query;
use ReflectionClass;
use ReflectionException;

class RequestParser
{
	/**
	 * @return Request
	 * @throws Exception
	 */
	public static function cgi(): Request {

		$request = new Request();

		self::readHeaders($request);
		self::readUrl($request);
		self::readPath($request);
		self::readParams($request);
		self::readMethod($request);
		self::readPayload($request);

		return $request;
	}

	private static function readHeaders(Request &$request) {
		$headers = [];
		$copy_server = [
			'CONTENT_TYPE'   => 'Content-Type',
			'CONTENT_LENGTH' => 'Content-Length',
			'CONTENT_MD5'    => 'Content-Md5',
		];
		foreach($_SERVER as $key => $value) {
			if(substr($key, 0, 5) === 'HTTP_') {
				$key = substr($key, 5);
				if(!isset($copy_server[$key]) || !isset($_SERVER[$key])) {
					$key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $key))));
					$headers[$key] = $value;
				}
			}
			else if(isset($copy_server[$key])) {
				$headers[$copy_server[$key]] = $value;
			}
		}
		if(!isset($headers['Authorization'])) {
			if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
				$headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
			}
			else if(isset($_SERVER['PHP_AUTH_USER'])) {
				$basic_pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
				$headers['Authorization'] = 'Basic ' . base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $basic_pass);
			}
			else if(isset($_SERVER['PHP_AUTH_DIGEST'])) {
				$headers['Authorization'] = $_SERVER['PHP_AUTH_DIGEST'];
			}
		}

		$request->setHeaders($headers);
	}

	/**
	 * @param Request $request
	 *
	 * @throws Exception
	 */
	private static function readMethod(Request &$request) {
		$method = strtoupper($_SERVER['REQUEST_METHOD']);

		$className = Method::class;

		if(!defined("$className::$method")) {
			throw new Exception("Unknown OData HTTP Method `$method`");
		}
		$request->setMethod($method);
	}

	/**
	 * @param Request $request
	 *
	 * @throws ReflectionException
	 * @throws Exception
	 */
	private static function readParams(Request &$request): void {
		$parameters = [];

		$parse = (object) parse_url($request->getUrl());
		if(isset($parse->query)) {

			parse_str($parse->query, $queryParams);

			$queryClass = new ReflectionClass(Query::class);
			$specificationParams = array_flip($queryClass->getConstants());

			foreach($queryParams as $key => $value) {
				if(!isset($specificationParams[$key])) {
					throw new Exception("Unsupported query params");
				}
				$parameters[] = new Parameter($key, $value);
			}
		}

		$request->setParams($parameters);
	}

	private static function readPath(Request &$request): void {
		$parse = (object) parse_url($request->getUrl());

		$request->setPath($parse->path);
	}

	/**
	 * @param Request $request
	 *
	 * @throws Exception
	 */
	private static function readPayload(Request &$request) {

		$contentLength = floatval($_SERVER['CONTENT_LENGTH']);

        if (in_array($request->getMethod(), [Method::PATCH, Method::POST, Method::PUT])) {

            if ($contentLength) {

                $payload = file_get_contents('php://input');

                if (mb_strlen($payload) != $contentLength) {
                    throw new Exception("Payload length not equal to header length");
                }

                $request->setPayLoad($payload);
            } else {
                throw new Exception("No payload provided");
            }
		}
	}

	/**
	 * @param Request $request
	 *
	 * @throws Exception
	 */
	private static function readUrl(Request &$request): void {
		$requestUri = $_SERVER['REQUEST_URI'];
		if(mb_strpos($requestUri, Configuration::me()->getContextPath()) == 0) {
			$requestUri = mb_substr($requestUri, mb_strlen(Configuration::me()->getContextPath()));
		}
		else {
			throw new Exception("Context path not found");
		}

		$request->setUrl($requestUri);
	}
}