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
	
	
	}


?>