<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	A client which obtains JSON data from HTTP
	 *	endpoints.
	 *
	 *	Each JSONClient object is associated with a
	 *	service, given by a URL.  The JSONClient may
	 *	then be directed to make requests to endpoints
	 *	of this service, which are defined as URIs
	 *	which have the URL given for the service, with
	 *	an appended component which gives the endpoint's
	 *	name.
	 */
	class JSONClient {
		
		
		private $url;
		
		
		/**
		 *	The HTTPRequest object that the client will use
		 *	to make HTTP requests.
		 */
		public $request;
		
		
		/**
		 *	Creates a new JSON HTTP client.
		 *
		 *	\param [in] $url
		 *		The base URL of the service this
		 *		JSON HTTP client will connect to.
		 */
		public function __construct ($url) {
		
			//	Assign and normalize URL
			//
			//	Normalizing the URL means appending
			//	it with a slash if it doesn't already
			//	end in one
			$this->url=Regex::Replace(
				'/(?<!\\/)$/u',
				'/',
				$url
			);
			
			//	Create an HTTP request object to use
			//	to handle all HTTP requests for JSON
			$this->request=new HTTP\Request();
			$this->request->user_agent='CivicInfo BC JSON Client';
			//	Sensible defaults
			$this->max_header_bytes=65536;
			$this->max_body_bytes=65535;
		
		}
		
		
		private function make_url ($endpoint, $data=null) {
		
			$retr=$this->url.Regex::Replace(
				'/^\\//u',
				'',
				$endpoint
			);
			
			if (is_null($data)) return $retr;
			
			$first=true;
			foreach ($data as $key=>$value) {
			
				if ($first) $retr.='?';
				else $retr.='&';
				
				$retr.=rawurlencode($key).'='.rawurlencode($value);
			
			}
			
			return $retr;
		
		}
		
		
		private function check ($response) {
		
			//	Check that status code is 2xx
			if (($response->status/100)!==2) throw new \Exception(
				sprintf(
					'JSON Request to %s failed with %s %s',
					$this->request->url,
					$response->status,
					$response->response
				)
			);
		
		}
		
		
		private function complete ($response, $depth=null) {
		
			//	Check to make sure the response is good
			$this->check($response);
			
			//	Fetch/decode the body, and if there's
			//	no body, return null
			if (($body=$response->GetBody())==='') return null;
			
			//	Decode JSON
			return JSON::Decode($body,$depth);
		
		}
		
		
		/**
		 *	Performs a GET request against a certain
		 *	endpoint of the service this JSON HTTP
		 *	client connects to.
		 *
		 *	\param [in] $endpoint
		 *		The endpoint against which the request
		 *		shall be issued.
		 *	\param [in] $data
		 *		The data to be sent as the query string.
		 *		Defaults to \em null in which case no
		 *		query string will be sent.
		 *	\param [in] $depth
		 *		The maximum depth to which to recurse in
		 *		decoding the JSON response.  Defaults to
		 *		\em null which will use a sensible
		 *		default.
		 *
		 *	\return
		 *		An object representing the JSON the server
		 *		returned, \em null if there was no response.
		 */
		public function Get ($endpoint, $data=null, $depth=null) {
		
			//	Clear/reset defaults
			$this->request->headers=array();
			$this->request->body='';
			
			//	Setup this request
			$this->request->url=$this->make_url($endpoint,$data);
			$this->request->verb='GET';
			
			//	GET
			return $this->complete(
				$this->request->Execute()
			);
		
		}
		
		
		/**
		 *	Perfoms a POST request against a certain endpoint
		 *	of the service this JSON HTTP client connects
		 *	to.
		 *
		 *	\param [in] $endpoint
		 *		The endpoint against which the request shall
		 *		be issued.
		 *	\param [in] $data
		 *		The data to be sent as JSON as the body of
		 *		the POST request.  Defaults to \em null in
		 *		which case no body will be sent.
		 *	\param [in] $depth
		 *		The maximum depth to which to recurse in
		 *		decoding the JSON response.  Defaults to
		 *		\em null which will use a sensible default.
		 *
		 *	\return
		 *		An object representing the JSON that server
		 *		returned, \em null if there was no response.
		 */
		public function Post ($endpoint, $data=null, $depth=null) {
		
			//	Setup this request
			$this->request->body=JSON::Encode($data,$depth);
			$this->request->url=$this->make_url($endpoint);
			$this->request->verb='POST';
			$this->request->headers=array('Content-Type' => 'application/json');
			
			//	POST
			return $this->complete(
				$this->request->Execute()
			);
		
		}
	
	
	}


?>