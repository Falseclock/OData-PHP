<?php

namespace Falseclock\OData\Common;

class Messages
{
	/**
	 * Format a message to show error when given url is malformed
	 *
	 * @param string $url The malformed url
	 *
	 * @return string The formatted message
	 */
	public static function urlMalformedUrl($url) {
		return "Bad Request - The url '$url' is malformed";
	}
}