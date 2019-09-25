<?php
//
// ABNF to REGEX Library
//
// Copyright (c) 2013-2017 Michael R Sweet
//
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
//
// The above copyright notice and this permission notice shall be included in all
// copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
// SOFTWARE.
//

class Parser
{
	const ABNF_CORE        = [
		"alpha"  => [ "%x41-5a", "/", "%x61-7a" ],
		"bit"    => [ "\"0\"", "/", "\"1\"" ],
		"char"   => [ "%x01-7f" ],
		"cr"     => [ "%x0d" ],
		"crlf"   => [ "cr", "lf" ],
		"ctl"    => [ "%x00-1f", "/", "%x7f" ],
		"digit"  => [ "%x30-39" ],
		"dquote" => [ "%x22" ],
		"hexdig" => [ "digit", "/", "\"%x41-46\"", "/", "\"%x61-66\"" ],
		"htab"   => [ "%x09" ],
		"lf"     => [ "%x0a" ],
		"lwsp"   => [ "*", "(", "wsp", "/", "crlf", "wsp", ")" ],
		"octet"  => [ "%x00-ff" ],
		"sp"     => [ "%x20" ],
		"vchar"  => [ "%x21-7e" ],
		"wsp"    => [ "sp", "/", "htab" ]
	];
	const ABNF_INSENSITIVE = 0;
	const ABNF_LOWERCASE   = 2;
	const ABNF_SENSITIVE   = 1;
	const ABNF_UPPERCASE   = 3;
	public $errorString;
	public $errorLine;
	public $errorColumn;
	public $rules;

	public function __construct(string $content) {
		$this->load($content);
	}

	public function regex($name, $mode = self::ABNF_INSENSITIVE) {
		$rules = $this->rules;

		if(!array_key_exists($name, $rules))
			return ("");

		$alternatives = in_array("/", $rules[$name]);

		if($alternatives)
			$regex = "(";
		else
			$regex = "";

		$modstack = [];
		$mod = "";

		foreach($rules[$name] as $token) {
			if($token == "/") {
				/* Alternative */
				$regex .= "|";
			}

			else if($token == "(") {
				/* Grouping */
				$regex .= "(";
				array_push($modstack, $mod);
				$mod = "";
			}
			else if($token == "[") {
				/* Optional */
				$regex .= "(";
				array_push($modstack, "{0,1}");
				$mod = "";
			}
			else if($token == ")" || $token == "]") {
				/* Grouping/Optional */
				$mod = array_pop($modstack);
				$regex .= ")$mod";
				$mod = "";
			}
			else if($token[0] == "\"") {
				/* Literal String */
				$literal = substr($token, 1, -1);
				$litlen = strlen($literal);

				switch($mode) {
					case self::ABNF_INSENSITIVE :
						for($i = 0; $i < $litlen; $i++) {
							$litchar = $literal[$i];
							if(ctype_alpha($litchar))
								$regex .= "[" . strtoupper($litchar) . strtolower($litchar) . "]";
							else
								$regex .= preg_quote($litchar);
						}
						break;
					case self::ABNF_SENSITIVE :
						$regex .= preg_quote($literal);
						break;
					case self::ABNF_LOWERCASE :
						$regex .= preg_quote(strtolower($literal));
						break;
					case self::ABNF_UPPERCASE :
						$regex .= preg_quote(strtoupper($literal));
						break;
				}
			}
			else if(preg_match("/^([0-9]*)\\*([0-9]*)\$/", $token, $matches)) {
				/* Convert repetition to regex modifier */
				if($matches[2] == "") {
					if($matches[1] == "1")
						$mod = "+";
					else if($matches[1] == "0" || $matches[1] == "")
						$mod = "*";
					else
						$mod = "{" . $matches[1] . ",}";
				}
				else
					$mod = "{" . $matches[1] . "," . $matches[2] . "}";
			}
			else if((int) $token > 0) {
				/* Convert repetition to regex modifier */
				$mod = "{" . $token . "," . $token . "}";
			}
			else if($token[0] == "%") {
				/* Convert character literals and ranges */
				$len = strlen($token);
				if(strpos($token, "-") !== false)
					$regex .= "[";

				for($i = 2; $i < $len; $i++) {
					$ch = 0;
					if($token[1] == "b") {
						/* Binary */
						while($i < $len && ($token[$i] == "0" || $token[$i] == "1")) {
							$ch = $ch * 2 + (int) $token[$i];
							$i++;
						}
					}
					else if($token[1] == "x") {
						/* Hex */
						while($i < $len && ctype_xdigit($token[$i])) {
							if(ctype_digit($token[$i]))
								$ch = $ch * 16 + (int) $token[$i];
							else
								$ch = $ch * 16 + ord(strtolower($token[$i])) - 0x61 + 10;
							$i++;
						}
					}
					else {
						/* Decimal */
						while($i < $len && ctype_digit($token[$i])) {
							$ch = $ch * 16 + (int) $token[$i];
							$i++;
						}
					}

					$regex .= preg_quote(chr($ch));

					if($i < $len && $token[$i] == '-')
						$regex .= "-";
				}

				if(strpos($token, "-") !== false)
					$regex .= "]";
			}
			else {
				/* Import rule */
				if(array_key_exists($token, $rules))
					//$regex .= $this->regex($token, $mode);
					$regex .= "<{$token}>";
				else if(array_key_exists($token, self::ABNF_CORE))
					$regex .= $this->regex($token, $mode);
				else
					$regex .= "MISSING-$token";

				$regex .= $mod;
				$mod = "";
			}
		}

		if($alternatives)
			$regex .= ")";

		// Optimize common stuff that can be optimized
		$regex = str_replace([
								 "(0|1|2|3|4|5|6|7|8|9)",
								 "(a|b|c|d|e|f)",
								 "(A|B|C|D|E|F)",
								 "([Aa]|[Bb]|[Cc]|[Dd]|[Ee]|[Ff])",
								 "(a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z)",
								 "(A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z)",
								 "([Aa]|[Bb]|[Cc]|[Dd]|[Ee]|[Ff]|[Gg]|[Hh]|[Ii]|[Jj]|[Kk]|[Ll]|[Mm]" .
								 "|[Nn]|[Oo]|[Pp]|[Qq]|[Rr]|[Ss]|[Tt]|[Uu]|[Vv]|[Ww]|[Xx]|[Yy]|[Zz])",
								 "]|[",
								 "[a-z0-9]|\\-",
								 "[A-Z0-9]|\\-",
								 "[A-Za-z0-9]|\\-",
								 "a-z0-9]|_",
								 "A-Z0-9]|_",
								 "A-Za-z0-9]|_",
								 "a-z0-9]|\\.",
								 "A-Z0-9]|\\.",
								 "A-Za-z0-9]|\\.",
								 "[a-f0-9]|\\-",
								 "[A-F0-9]|\\-",
								 "[A-Fa-f0-9]|\\-"
							 ],
							 [
								 "[0-9]",
								 "[a-f]",
								 "[A-F]",
								 "[A-Fa-f]",
								 "[a-z]",
								 "[A-Z]",
								 "[A-Za-z]",
								 "",
								 "[-a-z0-9]",
								 "[-A-Z0-9]",
								 "[-A-Za-z0-9]",
								 "_a-z0-9]",
								 "_A-Z0-9]",
								 "_A-Za-z0-9]",
								 ".a-z0-9]",
								 ".A-Z0-9]",
								 ".A-Za-z0-9]",
								 "[-a-f0-9]",
								 "[-A-F0-9]",
								 "[-A-Fa-f0-9]"
							 ],
							 $regex
		);
		$regex = preg_replace("/\\(\\[([^\\]]+)\\]\\)/", "[\\1]", $regex);

		return ($regex);
	}

	private function load(string $content) {

		$names = [];
		$rules = [];

		$len = strlen($content);
		$name = "";
		$token = "";
		$tokens = [];
		$linenum = 1;
		$col = 0;

		for($i = 0; $i < $len; $i++) {
			switch($content[$i]) {
				case ";" :
					if($token != "")
						$tokens[sizeof($tokens)] = $token;

					// Comment - skip to end of line
					do {
						$i++;
						$col++;
					}
					while($i < $len && $content[$i] != "\n");

					if($i < $len && $content[$i] == "\n") {
						$linenum++;
						$col = 0;
					}
					break;

				case "\n" :
				case " " :
				case "\t" :
				case "\r" :

					if($content[$i] == " ")
						$col++;
					else if($content[$i] == "\t")
						$col = $col + 8 - ($col % 8);
					else if($content[$i] == "\n") {
						$linenum++;
						$col = 0;
					}

					if($token == "")
						break;

					if(preg_match("/^[ \t]+=/", substr($content, $i))) {
						if($name != "")
							$rules[$name] = $tokens;

						while($i < $len && ctype_space($content[$i])) {
							$i++;

							if($content[$i] == " ")
								$col++;
							else if($content[$i] == "\t")
								$col = $col + 8 - ($col % 8);
						}

						$name = $token;

						if(($i + 1) < $len && $content[$i + 1] == "/") {
							$i++;
							$col++;

							if(array_key_exists($name, $rules))
								$tokens = $rules[$name];
							else
								$tokens = [];
						}
						else
							$tokens = [];
					}
					else {
						$tokens[sizeof($tokens)] = $token;
						if(!array_key_exists($token, $names))
							$names[$token] = [ $linenum, $col - strlen($token) - 1 ];
					}

					$token = "";
					break;

				case "<" :
					if($token != "")
						$tokens[sizeof($tokens)] = $token;

					if(preg_match("/^<([a-zA-Z][-a-zA-Z0-9]*)>/",
								  substr($content, $i),
								  $matches
					)) {
						$i += strlen($matches[1]) + 1;
						$col += strlen($matches[1]) + 1;
						$tokens[sizeof($tokens)] = $matches[1];
					}
					else {
						$this->errorString = "Bad rule name.";
						$this->errorColumn = $col;
						$this->errorLine = $linenum;

						return (false);
					}
					break;

				case "(" :
				case ")" :
				case "[" :
				case "]" :
				case "/" :
					$col++;

					if($token != "")
						$tokens[sizeof($tokens)] = $token;

					$tokens[sizeof($tokens)] = $content[$i];
					$token = "";
					break;

				case "'" :
					$col++;

					if($token != "")
						$tokens[sizeof($tokens)] = $token;

					$token = "\"";
					for($i++; $i < $len && $content[$i] != "'"; $i++) {
						$token .= $content[$i];
						$col++;
					}
					$token .= "\"";

					if($i >= $len) {
						$this->errorString = "Unterminated string.";
						$this->errorColumn = $col;
						$this->errorLine = $linenum;

						return (false);
					}

					$col++;

					$tokens[sizeof($tokens)] = $token;
					$token = "";
					break;

				case "\"" :
					$col++;

					if($token != "")
						$tokens[sizeof($tokens)] = $token;

					$token = "\"";
					for($i++; $i < $len && $content[$i] != "\""; $i++) {
						$token .= $content[$i];
						$col++;
					}
					$token .= "\"";

					if($i >= $len) {
						$this->errorString = "Unterminated string.";
						$this->errorColumn = $col;
						$this->errorLine = $linenum;

						return (false);
					}

					$col++;

					$tokens[sizeof($tokens)] = $token;
					$token = "";
					break;

				case "0" :
				case "1" :
				case "2" :
				case "3" :
				case "4" :
				case "5" :
				case "6" :
				case "7" :
				case "8" :
				case "9" :
					if($token != "") {
						$col++;

						$token .= $content[$i];
						break;
					}
					break;
				case "*" :
					if($token != "") {
						$this->errorString = "Unexpected repetition.";
						$this->errorColumn = $col;
						$this->errorLine = $linenum;

						return (false);
					}

					if(preg_match("/^([0-9]+|[0-9]*\\*[0-9]*)[a-zA-Z\\[(<]/",
								  substr($content, $i),
								  $matches
					)) {
						$i += strlen($matches[1]) - 1;
						$col += strlen($matches[1]) - 1;
						$tokens[sizeof($tokens)] = $matches[1];
					}
					else {
						$this->errorString = "Bad repetition.";
						$this->errorColumn = $col;
						$this->errorLine = $linenum;

						return (false);
					}
					break;

				case '-' :
					$col++;

					if($token != "")
						$token .= "-";
					else {
						$this->errorString = "Unexpected character '$content[$i]'.";
						$this->errorColumn = $col;
						$this->errorLine = $linenum;

						return (false);
					}
					break;

				case '%' :
					if($token != "") {
						$this->errorString = "Unexpected character value.";
						$this->errorColumn = $col;
						$this->errorLine = $linenum;

						return (false);
					}

					if(preg_match("/^(%b[01]+(\\.[01]+)*|" . "%d[0-9]+(\\.[0-9]+)*|" . "%x[0-9a-fA-F]+(\\.[0-9a-fA-F]+)*)[ \t\n\r]/",
								  substr($content, $i),
								  $matches
					)) {
						$i += strlen($matches[1]);
						$col += strlen($matches[1]);
						$tokens[sizeof($tokens)] = $matches[1];
					}
					else if(preg_match("/^(%b[01]+-[01]+|" . "%d[0-9]+-[0-9]+|" . "%x[0-9a-fA-F]+-[0-9a-fA-F]+)[ \t\n\r]/",
									   substr($content, $i),
									   $matches
					)) {
						$i += strlen($matches[1]);
						$col += strlen($matches[1]);
						$tokens[sizeof($tokens)] = $matches[1];
					}
					else {
						$this->errorString = "Bad character value.";
						$this->errorColumn = $col;
						$this->errorLine = $linenum;

						return (false);
					}
					break;

				default :
					$col++;

					if(ctype_alpha($content[$i]))
						$token .= $content[$i];
					else {
						$this->errorString = "Unexpected character '$content[$i]'.";
						$this->errorColumn = $col;
						$this->errorLine = $linenum;

						return (false);
					}
					break;
			}
		}

		if($token != "")
			$tokens[sizeof($tokens)] = $token;

		if($name != "")
			$rules[$name] = $tokens;

		// Validate all referenced names
		foreach($names as $name => $pos) {
			if(!array_key_exists($name, $rules) && !array_key_exists($name, self::ABNF_CORE)) {
				$this->errorString = "Missing rule '$name'.";
				$this->errorLine = $pos[0];
				$this->errorColumn = $pos[1];

				return (false);
			}
		}

		$this->rules = $rules;

		// Return the loaded rules
		return $this->rules;
	}
}