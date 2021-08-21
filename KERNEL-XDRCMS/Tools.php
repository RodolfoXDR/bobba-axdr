<?php
class Tool
{
	const HTMLEntities = ['"' => '&quot;', '&' => '&amp;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;', '¡' => '&iexcl;', '¢' => '&cent;', '£' => '&pound;', '¤' => '&curren;', '¥' => '&yen;', '¦' => '&brvbar;', '§' => '&sect;', '¨' => '&uml;', '©' => '&copy;', 'ª' => '&ordf;', '«' => '&laquo;', '¬' => '&not;', '­' => '&shy;', '®' => '&reg;', '¯' => '&macr;', '°' => '&deg;', '±' => '&plusmn;', '²' => '&sup2;', '³' => '&sup3;', '´' => '&acute;', 'µ' => '&micro;', '¶' => '&para;', '·' => '&middot;', '¸' => '&cedil;', '¹' => '&sup1;', 'º' => '&ordm;', '»' => '&raquo;', '¼' => '&frac14;', '½' => '&frac12;', '¾' => '&frac34;', '¿' => '&iquest;', 'À' => '&Agrave;', 'Á' => '&Aacute;', 'Â' => '&Acirc;', 'Ã' => '&Atilde;', 'Ä' => '&Auml;', 'Å' => '&Aring;', 'Æ' => '&AElig;', 'Ç' => '&Ccedil;', 'È' => '&Egrave;', 'É' => '&Eacute;', 'Ê' => '&Ecirc;', 'Ë' => '&Euml;', 'Ì' => '&Igrave;', 'Í' => '&Iacute;', 'Î' => '&Icirc;', 'Ï' => '&Iuml;', 'Ð' => '&ETH;', 'Ñ' => '&Ntilde;', 'Ò' => '&Ograve;', 'Ó' => '&Oacute;', 'Ô' => '&Ocirc;', 'Õ' => '&Otilde;', 'Ö' => '&Ouml;', '×' => '&times;', 'Ø' => '&Oslash;', 'Ù' => '&Ugrave;', 'Ú' => '&Uacute;', 'Û' => '&Ucirc;', 'Ü' => '&Uuml;', 'Ý' => '&Yacute;', 'Þ' => '&THORN;', 'ß' => '&szlig;', 'à' => '&agrave;', 'á' => '&aacute;', 'â' => '&acirc;', 'ã' => '&atilde;', 'ä' => '&auml;', 'å' => '&aring;', 'æ' => '&aelig;', 'ç' => '&ccedil;', 'è' => '&egrave;', 'é' => '&eacute;', 'ê' => '&ecirc;', 'ë' => '&euml;', 'ì' => '&igrave;', 'í' => '&iacute;', 'î' => '&icirc;', 'ï' => '&iuml;', 'ð' => '&eth;', 'ñ' => '&ntilde;', 'ò' => '&ograve;', 'ó' => '&oacute;', 'ô' => '&ocirc;', 'õ' => '&otilde;', 'ö' => '&ouml;', '÷' => '&divide;', 'ø' => '&oslash;', 'ù' => '&ugrave;', 'ú' => '&uacute;', 'û' => '&ucirc;', 'ü' => '&uuml;', 'ý' => '&yacute;', 'þ' => '&thorn;', 'ÿ' => '&yuml;', 'Œ' => '&OElig;', 'œ' => '&oelig;', 'Š' => '&Scaron;', 'š' => '&scaron;', 'Ÿ' => '&Yuml;', 'ƒ' => '&fnof;', 'ˆ' => '&circ;', '˜' => '&tilde;', 'Α' => '&Alpha;', 'Β' => '&Beta;', 'Γ' => '&Gamma;', 'Δ' => '&Delta;', 'Ε' => '&Epsilon;', 'Ζ' => '&Zeta;', 'Η' => '&Eta;', 'Θ' => '&Theta;', 'Ι' => '&Iota;', 'Κ' => '&Kappa;', 'Λ' => '&Lambda;', 'Μ' => '&Mu;', 'Ν' => '&Nu;', 'Ξ' => '&Xi;', 'Ο' => '&Omicron;', 'Π' => '&Pi;', 'Ρ' => '&Rho;', 'Σ' => '&Sigma;', 'Τ' => '&Tau;', 'Υ' => '&Upsilon;', 'Φ' => '&Phi;', 'Χ' => '&Chi;', 'Ψ' => '&Psi;', 'Ω' => '&Omega;', 'α' => '&alpha;', 'β' => '&beta;', 'γ' => '&gamma;', 'δ' => '&delta;', 'ε' => '&epsilon;', 'ζ' => '&zeta;', 'η' => '&eta;', 'θ' => '&theta;', 'ι' => '&iota;', 'κ' => '&kappa;', 'λ' => '&lambda;', 'μ' => '&mu;', 'ν' => '&nu;', 'ξ' => '&xi;', 'ο' => '&omicron;', 'π' => '&pi;', 'ρ' => '&rho;', 'ς' => '&sigmaf;', 'σ' => '&sigma;', 'τ' => '&tau;', 'υ' => '&upsilon;', 'φ' => '&phi;', 'χ' => '&chi;', 'ψ' => '&psi;', 'ω' => '&omega;', 'ϑ' =>  '&thetasym;', 'ϒ' => '&upsih;', 'ϖ' => '&piv;', ' ' => '&ensp;', ' ' => '&emsp;', ' ' => '&thinsp;', '‌' => '&zwnj;', '‍' => '&zwj;', '‎' => '&lrm;', '‏' => '&rlm;', '–' => '&ndash;', '—' => '&mdash;', '‘' => '&lsquo;', '’' => '&rsquo;', '‚' => '&sbquo;', '“' => '&ldquo;', '”' => '&rdquo;', '„' => '&bdquo;', '†' => '&dagger;', '‡' => '&Dagger;', '•' => '&bull;', '…' => '&hellip;', '‰' => '&permil;', '′' => '&prime;', '″' => '&Prime;', '‹' => '&lsaquo;', '›' => '&rsaquo;', '‾' => '&oline;', '⁄' => '&frasl;', '€' => '&euro;', 'ℑ' => '&image;', '℘' => '&weierp;', 'ℜ' => '&real;', '™' => '&trade;', 'ℵ' => '&alefsym;', '←' => '&larr;', '↑' => '&uarr;', '→' => '&rarr;', '↓' => '&darr;', '↔' => '&harr;', '↵' => '&crarr;', '⇐' => '&lArr;', '⇑' => '&uArr;', '⇒' => '&rArr;', '⇓' => '&dArr;', '⇔' => '&hArr;', '∀' => '&forall;', '∂' => '&part;', '∃' => '&exist;', '∅' => '&empty;', '∇' => '&nabla;', '∈' => '&isin;', '∉' => '&notin;', '∋' => '&ni;', '∏' => '&prod;', '∑' => '&sum;', '−' => '&minus;', '∗' => '&lowast;', '√' => '&radic;', '∝' => '&prop;', '∞' => '&infin;', '∠' => '&ang;', '∧' => '&and;', '∨' => '&or;', '∩' => '&cap;', '∪' => '&cup;', '∫' => '&int;', '∴' => '&there4;', '∼' => '&sim;', '≅' => '&cong;', '≈' => '&asymp;', '≠' => '&ne;', '≡' => '&equiv;', '≤' => '&le;', '≥' => '&ge;', '⊂' => '&sub;', '⊃' => '&sup;', '⊄' => '&nsub;', '⊆' => '&sube;', '⊇' => '&supe;', '⊕' => '&oplus;', '⊗' => '&otimes;', '⊥' => '&perp;', '⋅' => '&sdot;', '⌈' => '&lceil;', '⌉' => '&rceil;', '⌊' => '&lfloor;', '⌋' => '&rfloor;', '〈' => '&lang;', '〉' => '&rang;', '◊' => '&loz;', '♠' => '&spades;', '♣' => '&clubs;', '♥' => '&hearts;', '♦' => '&diams;', '\\' => '&#92;'];
	const QUOTES = ['"' => '&quot;', '\'' => '&#039;'];
	
	// GLOBAL USAGES
	public static function ApplyEntities($a, &...$p)
	{
		foreach($p as &$v)
			if(is_array($v))
				foreach($v as &$V)
					$V = str_replace(array_keys($a), array_values($a), mb_convert_encoding($V, 'UTF-8', mb_detect_encoding($V, 'UTF-8,ISO-8859-1,ISO-8859-15', true)));
			else
				$v = str_replace(array_keys($a), array_values($a), mb_convert_encoding($v, 'UTF-8', mb_detect_encoding($v, 'UTF-8,ISO-8859-1,ISO-8859-15', true)));
	}
	
	public static function DecodeEntities($a, &...$p)
	{
		foreach($p as &$v)
			if(is_array($v))
				foreach($v as &$V)
					$V = str_replace(array_values($a), array_keys($a), mb_convert_encoding($V, 'UTF-8', mb_detect_encoding($V, 'UTF-8,ISO-8859-1,ISO-8859-15', true)));
			else
				$v = str_replace(array_values($a), array_keys($a), mb_convert_encoding($v, 'UTF-8', mb_detect_encoding($v, 'UTF-8,ISO-8859-1,ISO-8859-15', true)));
	}

	
	
	public static function IsNumeric(...$p)
	{
		foreach($p as $v)
			if(!is_numeric($v))
				return false;
		return true;
	}
	
	public static function StartsWith($s, ...$pMs)
	{
		foreach($pMs as $p)
			if(substr_compare($s, $p, 0, strlen($p)))
				return false;
		
		return true;
	}
	
	public static function HasNumbers($s)
	{
		return preg_match('`[0-9]`', $s);
	}
	
	public static function IsMail($m)
	{
		return filter_var($m, FILTER_VALIDATE_EMAIL);
	}
	
	public static function IsValidDate($d, $m, $y)
	{
		return self::IsNumeric($d, $m, $y) && checkdate($m, $d, $y);
	}
	
	public static function Random($l, $n = true, $L = true, $o = '')
	{
		$c = '';
		$c .= $n ? '0123456789' : '';
		$c .= $L ? 'QWERTYUIOPASDFGHJKLLZXCVBNMqwertyuiopasdfghjklzxcvbnm' : '';
		$c .= $o;

		$s = '';
		$C = 0;
		while ($C < $l)
		{ 
			$s .= substr($c, rand(0, strlen($c) -1), 1);
			$C++;
		}

		return $s;
	}
	
	public static function Hash($s)
	{
		return str_replace('$2x$07$ifostercmspoweredbymr', '', crypt($s, '$2x$07$ifostercmspoweredbymrhash$'));

	}
	
	public static function HashHabboLi($s, $t){
		$c = sha1(strtolower($s) . md5($t));
		$c = hash('gost', $c);
		$c = hash('whirlpool', $c);
		$c = hash('sha512', $c);
		return $c;
	}
	
	public static function DecodeBBText($s)
	{
		$str = preg_replace_callback('/\[code\](.*?)\[\/code\]/is', function($find) { return "[decodeNow]" . base64_encode($find[0]) . "[/decodeNow]"; }, $s);
           
		$ss = ['/\[b\](.*?)\[\/b\]/is', '/\[i\](.*?)\[\/i\]/is', '/\[u\](.*?)\[\/u\]/is', '/\[s\](.*?)\[\/s\]/is', '/\[quote\](.*?)\[\/quote\]/is', '/\[link\=(.*?)\](.*?)\[\/link\]/is', '/\[url\=(.*?)\](.*?)\[\/url\]/is', '/\[color\=(.*?)\](.*?)\[\/color\]/is', '/\[size=small\](.*?)\[\/size\]/is', '/\[size=large\](.*?)\[\/size\]/is', '/\[habbo\=(.*?)\](.*?)\[\/habbo\]/is', '/\[room\=(.*?)\](.*?)\[\/room\]/is', '/\[group\=(.*?)\](.*?)\[\/group\]/is'];
		$sr = ["<b>$1</b>", "<i>$1</i>", "<u>$1</u>", "<s>$1</s>", "<div class=\"bbcode-quote\">$1</div>", "<a href=\"$1\">$2</a>", "<a href=\"$1\">$2</a>", "<span style=\"color: $1;\">$2</span>", "<span style=\"font-size: 9px;\">$1</span>", "<span style=\"font-size: 14px;\">$1</span>", "<a href=\"/home/$1/id\">$2</a>", "<a onclick=\"roomForward(this, '$1', 'private'); return false;\" target=\"client\" href=\"/client?forwardId=2&roomId=$1\">$2</a>", "<a href=\"/groups/$1/id\">$2</a>"];
 
		$s = preg_replace ($ss, $sr, $s);
		$s = preg_replace_callback('/\[decodeNow\](.*?)\[\/decodeNow\]/is', function($find) { $p = $find[0]; $p = str_replace("[decodeNow]", "", $p);$p = str_replace("[/decodeNow]", "", $p);$p = "<pre>" . base64_decode($p) . "</pre>"; $p = str_replace("[code]", "", $p); $p = str_replace("[/code]", "", $p); return $p; }, $s);

		return $s;
	}
	
	public static function CheckCaptcha($r) {
		require_once KERNEL . 'APIs' . DS . 'Google.Recaptcha.php';
		return ReCaptcha::Verify($r)->IsSuccess();
	}

	public static function GetCharset($s) {
		return str_ireplace('ascii', 'ISO-8859-1', mb_detect_encoding($s));
	}

	public static function ChangeCMSCharset($s) {
		// substitution?
		return htmlspecialchars_decode(htmlentities($s, ENT_NOQUOTES, ini_get('default_charset')), ENT_NOQUOTES);
	}
	
	public static function Tags($s){
		return str_replace(['%HOST%', '%NAME%','%HOTELNAME%'], [WWW, User::$Data['name'], HotelName], $s);
	}
	
public static function ParseUnixTime($t)
	{
		$s = '--';

		if(!is_numeric($t))
			return $s;

		$t = time() - $t;
		if ($t == 0)
			return Text::Get(Text::TIME_NOW);
		else if ($t < 0)
		{
			$t *= -1;
			$s = Text::Get(Text::TIME_FUTURE);
		}
		else
			$s = Text::Get(Text::TIME_PAST);

		if ($t < 60)
			$s = $s . ' ' . ($t < 15) ? Text::Get2(Text::TIME_SOME, Text::TIME_SECONDS) : $t . Text::Get(Text::TIME_SECONDS);
		else if ($t <= 3600)
		{
			$t = round($t / 60);
			$s = $s . ' ' . $t . Text::Get(Text::TIME_MINUTE) . (($t > 1) ? 's' : '');
		}
		else if ($t <= 86400)
		{
			$t = round($t / 3600);
			$s = $s . ' ' . $t . Text::Get(Text::TIME_HOUR) . (($t > 1) ? 's' : '');
		}
		else if ($t <= 2629800)
		{
			$t = explode('.', ($t / 86400))[0];
			if($t < 7)
				$s = $s . ' ' . $t . Text::Get(Text::TIME_DAY) . (($t > 1) ? 's' : '');
			else
			{
				$t = ceil($t / 7);
				$s = $s . ' ' . $t . Text::Get(Text::TIME_WEEK) . (($t > 1) ? 's' : '');
			}
		}
		else if ($t <= 31557600)
		{
			$t = explode('.', ($t / 2629800))[0];
			$s = $s . ' ' . $t . Text::Get(Text::TIME_MONTH) . (($t > 1) ? 'es' : '');
		}
		else
		{
			$t = explode('.', ($t / 31557600))[0];
			$s = $s . ' ' . $t . Text::Get(Text::TIME_YEAR) . (($t > 1) ? 's' : '');
		}
		
		return $s;
	}
	
	public static function SendEmail($to, $subject, $body)
	{
		if(!mail($to, $subject, $body, 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf8' . "\r\n"))
		{
			print_r(error_get_last());
			exit;
		}
	}

	// CORE USAGES
	public static function SetIp()
	{
		/*if(array_key_exists('HTTP_X_SUCURI_CLIENTIP', $_SERVER))
			define('IP', str_replace('::1', '127.0.0.1', $_SERVER['HTTP_X_SUCURI_CLIENTIP']));
		else if(array_key_exists('HTTP_CLIENT_IP', $_SERVER))
			define('IP', str_replace('::1', '127.0.0.1', $_SERVER['HTTP_CLIENT_IP']));
		else*/ if(array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER))
			define('IP', str_replace('::1', '127.0.0.1', $_SERVER['HTTP_X_FORWARDED_FOR']));
		else if(array_key_exists('REMOTE_ADDR', $_SERVER))
			define('IP', str_replace('::1', '127.0.0.1', $_SERVER['REMOTE_ADDR']));
		else
			exit('Error IP');
	}
	
	public static function SetPHPInfo()
	{
		ini_set('default_charset', 'UTF-8');
		ini_set('expose_php', 0);
		ini_set('session.name', 'aXDR');
		ini_set('session.gc_probability', 10);
		ini_set('session.gc_divisor', 100);
		ini_set('session.cookie_httponly', 1);
		ini_set('session.use_only_cookies', 1);
		ini_set('session.gc_maxlifetime', 600);
		ini_set('zlib_output_compression', 'On');
		
		header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
	}
	
	public static function SessionStart()
	{
		if(!isset($_COOKIE['aXDR']))
			@session_start();
	}
}
?>