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
			$charset=null;
			foreach ($this->headers as $key=>$value) if (\CivicInfoBC\String::ToLower($key)==='content-type') {
			
				//	Parse
				$parser=new ContentType($value);
				$charset=$parser->charset;
				
				break;
			
			}
			
			//	Default to UTf-8
			return is_null($charset) ? 'utf-8' : $charset;
		
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