<?php

namespace Falseclock\OData\Common;

class Url
{
	const RFC3896_URL_REGEXP = "
# allow multiple groups with the same name
		(?J)
# protocol user host-ip port path path path querystring fragment
^
#protocol
(?:(?<scheme>[a-zA-Z][a-zA-Z\d+-.]*):)?
(?|
  #slash-slash
  \/\/
  #userinfo
  (?:
     #user
     (?<user>[a-zA-Z\d\-._~\!$&'()*+,;=%]*)
     #password
     (?::(?<pass>[a-zA-Z\d\-._~\!$&'()*+,;=:%]*))?
  @)?
  #host-ip
  (?<host>(?:[a-zA-Z\d-.%]+)|(?:\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})|(?:\[(?:[a-fA-F\d.:]+)\]))?
  #port
  (?::(?<port>\d*))?
  #slash-path
  (?<path>
	 (?:\/    [a-zA-Z\d\-._~\!$&'()*+,;=:@%]*   )*
  )

  #slash-path
  |(?<user>)(?<pass>)(?<host>)(?<port>)
   (?<path>\/  [a-zA-Z\d\-._~\!$&'()*+,;=:@%]+(?:\/[a-zA-Z\d\-._~\!$&'()*+,;=:@%]*)*)?

  #path
  |(?<user>)(?<pass>)(?<host>)(?<port>)
   (?<path>    [a-zA-Z\d\-._~\!$&'()*+,;=:@%]+(?:\/[a-zA-Z\d\-._~\!$&'()*+,;=:@%]*)*)

)?
#querystring
(?:\?(?<query>[a-zA-Z\d\-._~\!$&'()*+,;=:@%\/?]*))?
#fragment
(?:\#(?<fragment>[a-zA-Z\d\-._~\!$&'()*+,;=:@%\/?]*))?
$
";

	/**
	 * Url constructor.
	 *
	 * @param string $url
	 *
	 * @throws UrlFormatException
	 */
	public function __construct(string $url) {

		if(!preg_match(self::RFC3896_URL_REGEXP, $url, $matches)) {
			throw new UrlFormatException(Messages::urlMalformedUrl($url));
		}
	}
}