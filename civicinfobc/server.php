<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Provides a wrapper around the PHP $_SERVER
	 *	superglobal.
	 */
	class Server {
	
	
		private static function is_set ($key) {
		
			return isset($_SERVER[$key]);
		
		}
		
		
		/**
		 *	Gets a value from the $_SERVER superglobal,
		 *	coalescing to \em null if it does not
		 *	exist.
		 *
		 *	\param [in] $key
		 *		The key in the $_SERVER superglobal to
		 *		retrieve.
		 *
		 *	\return
		 *		The value associated with \em key in
		 *		$_SERVER if it exists, \em null otherwise.
		 */
		public static function Get ($key) {
		
			return self::is_set($key) ? $_SERVER[$key] : null;
		
		}
	
	
		/**
		 *	Determines whether this request is using
		 *	SSL/TLS.
		 *
		 *	\return
		 *		\em true if this request is using SSL/TLS,
		 *		\em false otherwise.
		 */
		public static function IsSSL () {
		
			return self::is_set('HTTPS') && (self::Get('HTTPS')!=='off');
		
		}
		
		
		/**
		 *	Gets the scheme this request was made with.
		 *
		 *	\return
		 *		The scheme.
		 */
		public static function GetScheme () {
		
			$retr='http';
			if (self::IsSSL()) $retr.='s';
			
			return $retr;
		
		}
		
		
		/**
		 *	Gets the host this request was made for.
		 *
		 *	In the rare case of on HTTP 1.0 request, it
		 *	may be impossible to tell which host the request
		 *	was made for, since HTTP 1.0 does not mandate
		 *	that a host header be sent.  In these cases
		 *	\"localhost\" will be returned.
		 *
		 *	\return
		 *		The host.
		 */
		public static function GetHost () {
		
			$retr=self::Get('HTTP_HOST');
			if (is_null($retr)) $retr='localhost';
			
			return $retr;
		
		}
		
		
		/**
		 *	Gets the port this request was made for.
		 *
		 *	\return
		 *		The port.
		 */
		public static function GetPort () {
		
			$retr=self::Get('SERVER_PORT');
			
			return is_null($retr) ? (self::IsSSL() ? 443 : 80) : intval($retr);
		
		}
		
		
		/**
		 *	Gets the path this request was made for, including
		 *	a leading slash.
		 *
		 *	\return
		 *		The path.
		 */
		public static function GetPath () {
		
			$retr=self::Get('HTTP_X_ORIGINAL_URL');
			return Regex::Replace(
				'/\\?.*$/u',
				'',
				Regex::Replace(
					'/\\#.*$/u',
					'',
					Regex::Replace(
						'/^(?!\\/)/u',
						'/',
						is_null($retr) ? self::Get('REQUEST_URI') : $retr
					)
				)
			);
		
		}
		
		
		/**
		 *	Gets the root of the URL this request was made
		 *	for, that is the scheme, host, and port (unless
		 *	the default port for the scheme was used).
		 *
		 *	\return
		 *		The root.
		 */
		public static function GetRoot () {
		
			$retr=self::GetScheme().'://'.self::GetHost();
			
			$port=self::GetPort();
			if (self::IsSSL()) {
			
				if ($port!==443) $retr.=':443';
			
			} else if ($port!==80) $retr.=':80';
			
			return $retr;
		
		}
	
	
		/**
		 *	Returns the URL this request was made for.
		 *
		 *	\return
		 *		The URL this request was made for.
		 */
		public static function GetURL () {
		
			return self::GetRoot().self::GetPath();
		
		}
	
	
	}


?>