<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	The base class for all Canada Post XML
	 *	API requests.
	 */
	class Request {
	
	
		/**
		 *	Retrieves the URL to which the request
		 *	should be made.
		 *
		 *	The base class implementation returns
		 *	the base URL for generic Canada Post
		 *	XML HTTP API requests.
		 *
		 *	\param [in] $production
		 *		\em true for the production URL,
		 *		\em false for the development URL.
		 *
		 *	\return
		 *		The URL for the request.
		 */
		public function GetURL ($production) {
		
			return 'https://'.($production ? 'soa-gw.canadapost.ca' : 'ct.soa-gw.canadapost.ca');
		
		}
		/**
		 *
		 */
		public function GetContentType () {
		
			return '*/*';
		
		}
		public function GetAccept () {
		
			return '*/*';
		
		}
		/**
		 *	Retrievse the HTTP method which should be
		 *	used to make the request.
		 *
		 *	If \"POST\" is returned the GetBody method
		 *	will be invoked to determine what should
		 *	be the body of the POST request.
		 *
		 *	The default implementation (which subclasses
		 *	may override) is to return \"GET\".
		 *
		 *	\return
		 *		The HTTP method.
		 */
		public function GetMethod () {
		
			return 'GET';
		
		}
		/**
		 *	Obtains the body of the request, if the
		 *	request is a POST request.
		 *
		 *	The default implementation (which subclasses
		 *	may override) is to return \em null.
		 *
		 *	\return
		 *		The body of the request.
		 */
		public function GetBody () {
		
			return null;
		
		}
		/**
		 *	Obtains the value that should be returned
		 *	after obtaining a certain response from
		 *	executing this request.
		 *
		 *	The default implementation (which subclasses
		 *	may override) is to return \em null.
		 *
		 *	\param [in] $response
		 *		A DOMDocument which represents the XML
		 *		that was received as a response from
		 *		the Canada Post XML API.
		 *
		 *	\return
		 *		The response object which is a result
		 *		of \em response.
		 */
		public function GetResponse (\DOMDocument $response) {
		
			return null;
		
		}
		
	
	}


?>