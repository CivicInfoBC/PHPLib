<?php


	namespace CivicInfoBC\HTTP;
	
	
	/**
	 *	A response to an HTTP request.
	 */
	class Response {
	
	
		/**
		 *	The numerical status that the server
		 *	returned.
		 */
		public $status;
		/**
		 *	The HTTP major version.  For example,
		 *	for HTTP 1.0 this would be 1.
		 */
		public $major_version;
		/**
		 *	The HTTP minor version.  For example,
		 *	for HTTP 1.0 this would be 0.
		 */
		public $minor_version;
		/**
		 *	The response the server returned.  This
		 *	describes the status code.  For example,
		 *	for most servers, if \em status is 200,
		 *	this will be \"OK\".
		 */
		public $response='';
		/**
		 *	An associative array of headers that the
		 *	server returned.
		 */
		public $headers=array();
		/**
		 *	The body of the response.
		 */
		public $body='';
		
		
		private function get_encoding () {
		
			//	Loop over headers and attempt to find
			//	the Content-Type header
			foreach ($this->headers as $key=>$value) if (\CivicInfoBC\String::ToLower($key)==='content-type') {
			
				//	Attempt to extract the character set
				if (is_null($match=\CivicInfoBC\Regex::Match(
					'/(?:^|\\s|;)charset\\s*\\=\\s*(\\S+)(?:$|\\s)/ui',
					$value
				))) break;
				
				//	Character set found, return it
				return $match[1];
			
			}
			
			//	Default to UTF-8
			return 'utf-8';
		
		}
		
		
		/**
		 *	Retrieves the body of the response, properly
		 *	converted according to the character set specified
		 *	in the content-type header (if any).
		 *
		 *	\return
		 *		The body of the response as a properly-encoded
		 *		string.
		 */
		public function GetBody () {
		
			return \CivicInfoBC\String::ConvertFrom(
				$this->body,
				$this->get_encoding()
			);
		
		}
	
	
	}


?>