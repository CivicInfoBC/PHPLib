<?php


	namespace CivicInfoBC\HTTP;
	
	
	/**
	 *	Encapsulates an HTTP request.
	 */
	class Request {
		
		
		private $handle;
	
	
		/**
		 *	The URL to which the HTTP request should
		 *	be made.
		 */
		public $url;
		/**
		 *	The HTTP verb that should be used.  Defaults
		 *	to \"GET\".
		 */
		public $verb='GET';
		/**
		 *	An associative array of headers that should be
		 *	sent.
		 */
		public $headers=array();
		/**
		 *	The body of the request that should be sent.
		 *	Is ignored if the request type does not warrant
		 *	sending a body.
		 */
		public $body='';
		/**
		 *	The referer to send.
		 */
		public $referer=null;
		/**
		 *	The user agent string to send.
		 */
		public $user_agent=null;
		/**
		 *	An associative array of cookies to send.
		 */
		public $cookies=array();
		/**
		 *	If \em true, the request will fail unless
		 *	SSL/TLS is used.  Defaults to \em false.
		 */
		public $require_ssl=false;
		/**
		 *	The maximum number of bytes which will be
		 *	accepted as part of the header before
		 *	the request will be terminated.
		 *
		 *	Default is \em null, which means an unlimited
		 *	number.
		 */
		public $max_header_bytes=null;
		/**
		 *	The maximum number of bytes which will be
		 *	accepted as part of the body before the request
		 *	will be terminated.
		 *
		 *	Default is \em null, which means an unlimited
		 *	number.
		 */
		public $max_body_bytes=null;
		/**
		 *	Whether the request should follow redirects
		 *	or fail upon a 3xx status code.  If
		 *	\em true, the request will follow up to
		 *	\em max_redirects redirects.  Defaults to
		 *	\em true.
		 */
		public $follow_redirects=true;
		/**
		 *	The maximum number of redirects the
		 *	request should follow.  If \em null
		 *	an unlimited number will be followed.
		 *	Defaults to 5.
		 */
		public $max_redirects=5;
		
		
		private function raise () {
		
			throw new \Exception(
				curl_error($this->handle),
				curl_errno($this->handle)
			);
		
		}
		
		
		private function set ($option, $value) {
		
			if (curl_setopt(
				$this->handle,
				$option,
				$value
			)===false) $this->raise();
		
		}
		
		
		/**
		 *	Creates a new request and optionally initializes
		 *	it with a URL.
		 *
		 *	\param [in] $url
		 *		The URL with which to initialize this request.
		 *		Optional.  If not specified a URL must be
		 *		manually set before executing the request.
		 */
		public function __construct ($url=null) {
		
			//	Try to create a cURL handle
			if (($this->handle=curl_init())===false) throw new \Exception('Could not create cURL handle');
			
			try {
			
			//	We need to clean up the cURL handle
			} catch (\Exception $e) {
			
				curl_close($this->handle);
				
				throw $e;
			
			}
			
			//	If libcurl is insecure, do not verify server
			//	certificates
			if (defined('LIBCURL_INSECURE') && LIBCURL_INSECURE) $this->set(CURLOPT_SSL_VERIFYPEER,false);
			
			//	If cURL debugging is desired, enable that
			if (defined('CURL_DEBUG') && CURL_DEBUG) $this->set(CURLOPT_VERBOSE,true);
		
			//	Copy in URL
			$this->url=$url;
		
		}
		
		
		/**
		 *	Cleans up all resources held by the HTTP request
		 *	object.
		 */
		public function __destruct () {
		
			//	Cleanup cURL handle
			curl_close($this->handle);
		
		}
		
		
		private function set_verb () {
		
			//	Normalize the HTTP verb
			//
			//	Since valid HTTP verbs are ASCII,
			//	there's no need for multibytes
			//	functions here
			$this->verb=strtoupper($this->verb);
			
			//	Is this a POST?
			if ($this->verb==='POST') {
			
				$this->set(CURLOPT_POST,true);
				$this->set(CURLOPT_POSTFIELDS,$this->body);
			
			//	Is this a HEAD?
			} else if ($this->verb==='HEAD') {
			
				$this->set(CURLOPT_NOBODY,true);
				
			//	Is this a DELETE?
			} else if ($this->verb==='DELETE') {
			
				$this->set(CURLOPT_CUSTOMREQUEST,'DELETE');
			
			//	Default to a GET
			} else {
			
				$this->set(CURLOPT_HTTPGET,true);
			
			}
		
		}
		
		
		private function set_headers () {
		
			//	Generate the headers in the format
			//	that cURL expects
			$arr=array();
			foreach ($this->headers as $key=>$value) $arr[]=sprintf(
				'%s:%s',
				$key,
				$value
			);
			
			$this->set(CURLOPT_HTTPHEADER,$arr);
		
		}
		
		
		private function set_cookies () {
		
			//	Generate cookies in the format that HTTP
			//	expects (since cURL just passes the
			//	CURLOPT_COOKIE string right through
			$str='';
			foreach ($this->cookies as $key=>$value) {
			
				if ($str!=='') $str.=';';
				
				$str.=URL::Escape($key).'='.URL::Escape($value);
			
			}
			
			$this->set(CURLOPT_COOKIE,$str);
		
		}
		
		
		private function set_require_ssl () {
		
			$accepted=CURLPROTO_HTTPS;
			if (!$this->require_ssl) $accepted|=CURLPROTO_HTTP;
			$this->set(CURLOPT_PROTOCOLS,$accepted);
		
		}
		
		
		private function set_redirect () {
		
			$this->set(CURLOPT_FOLLOWLOCATION,$this->follow_redirects);
		
			if ($this->follow_redirects) {
				
				if (is_null($this->max_redirects)) $this->max_redirects=0;
				$this->set(
					CURLOPT_MAXREDIRS,
					is_null($this->max_redirects) ? 0 : $this->max_redirects
				);
			
			}
		
		}
		
		
		private function set_callbacks ($response, &$ex) {
		
			//	Set a header function to handle/parse
			//	incoming headers
			$header_len=0;
			$request=$this;
			$this->set(
				CURLOPT_HEADERFUNCTION,
				function ($curl, $str) use ($request, $response, &$ex, &$header_len) {
				
					//	Determine how long this string is
					//	for deciding what to return
					$len=strlen($str);
					
					//	If the header is empty, ignore it
					if ($str==='') return $len;
					
					//	If the header is too long, error
					//	and bail out
					if (
						!is_null($request->max_header_bytes) &&
						(($header_len+$len)>$request->max_header_bytes)
					) {
					
						$ex=new \Exception('Headers too long');
						
						return 0;
					
					}
					
					$header_len+=$len;
				
					try {
					
						//	Is this the beginning of a new
						//	response?  I.e. after a redirect
						if (!is_null(
							$match=\CivicInfoBC\Regex::Match(
								'/^HTTP\\/(\\d+)\\.(\\d+)\\s+(\\d+)\\s+(.*)/u',
								$str
							)
						)) {
						
							//	It's a new response
							
							//	Clear all previously parsed
							//	headers
							$response->headers=array();
							$header_len=0;
							
							//	Fill in status and version number
							//	information
							$response->major_version=intval($match[1]);
							$response->minor_version=intval($match[2]);
							$response->status=intval($match[3]);
							$response->response=$match[4];
							
							//	We're done
							return $len;
						
						}
						
						//	Parse as a header
						if (is_null(
							$match=\CivicInfoBC\Regex::Match(
								'/^([^\\:]+)\\:(.*)$/u',
								$str
							)
						)) return $len;
						
						//	Add to the array in the appropriate
						//	position
						//
						//	Headers are ASCII, so it's safe to use
						//	the normal, mb-unaware trim function
						$response->headers[trim($match[1])]=trim($match[2]);
						
					} catch (\Exception $e) {
					
						$ex=$e;
						
						//	We guarantee above that zero-length
						//	headers will not get through, therefore
						//	zero is guaranteed to be different from
						//	$len, and therefore this will trigger
						//	an error in libcurl
						return 0;
					
					}
					
					//	Return exactly the number of bytes
					//	passed in
					return $len;
				
				}
			);
			
			//	Set a write function to handle incoming
			//	body
			$this->set(
				CURLOPT_WRITEFUNCTION,
				function ($curl, $str) use ($request, $response, &$ex) {
				
					//	We use ASCII strlen because we want
					//	the length in bytes, not code points
					$len=strlen($str);
				
					//	Would this be too long?
					if (
						!is_null($request->max_body_bytes) &&
						((strlen($response->body)+$len)>$request->max_body_bytes)
					) {
					
						$ex=new \Exception('Response too long');
					
						return 0;
						
					}
				
					//	Append
					$response->body.=$str;
					
					//	Return exactly the length of the string
					//	we were passed
					return $len;
				
				}
			);
			
		}
		
		
		/**
		 *	Performs the specified HTTP request.
		 *
		 *	\return
		 *		An HTTPResponse object describing the
		 *		response the server returned.
		 */
		public function Execute () {
		
			//	Set the URL
			$this->set(CURLOPT_URL,$this->url);
			
			//	Set the verb
			$this->set_verb();
			
			//	Set the headers
			$this->set_headers();
			
			//	Set the referer
			if (!is_null($this->referer)) $this->set(CURLOPT_REFERER,$this->referer);
			
			//	Set the user agent string
			if (!is_null($this->user_agent)) $this->set(CURLOPT_USERAGENT,$this->user_agent);
			
			//	Set cookies
			$this->set_cookies();
			
			//	Set require SSL
			$this->set_require_ssl();
			
			//	Set redirect-related options
			$this->set_redirect();
			
			//	Prepare an object to hold the response
			$response=new Response();
			
			//	This will hold an exception if one needs
			//	to be generated by a callback
			$ex=null;
			
			//	Set callbacks
			$this->set_callbacks($response,$ex);
			
			//	Perform
			if (curl_exec($this->handle)===false) {
			
				//	If we have a more detailed error
				//	than the one libcurl will provide,
				//	throw it, otherwise get the error
				//	from libcurl
				if (is_null($ex)) $this->raise();
				
				throw $ex;
			
			}
			
			return $response;
		
		}
	
	
	}


?>