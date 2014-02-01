<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	class Client {
	
	
		/**
		 *	The HTTP request that this object will
		 *	use to obtain data from the Canada Post
		 *	API.
		 */
		public $request;
		
		
		private $production;
		
		
		/**
		 *	Creates a new CanadaPostClient object which
		 *	interacts with the Canada Post XML HTTP
		 *	API.
		 *
		 *	\param [in] $username
		 *		The username to use to authenticate to
		 *		the Canada Post API.
		 *	\param [in] $password
		 *		The password to use to authenticate to
		 *		the Canada Post API.
		 *	\param [in] $production
		 *		\em true if the client should make requests
		 *		to production endpoints, \em false for
		 *		development endpoints.  If not explicitly
		 *		provided defaults to \em true.
		 */
		public function __construct ($username, $password, $production=true) {
		
			$this->production=$production;
			
			$this->request=new \CivicInfoBC\HTTP\Request();
			$this->request->headers=array(
				'Authorization' => 'Basic '.\CivicInfoBC\Base64::Encode(
					sprintf(
						'%s:%s',
						$username,
						$password
					)
				),
				'Accept-language' => 'en-CA'
			);
			$this->request->max_header_bytes=65536;
			$this->request->max_body_bytes=65536;
		
		}
		
		
		private static function raise_no_error_messages (\CivicInfoBC\HTTP\Response $response) {
		
			throw new \Exception(
				sprintf(
					'Canada Post reported error (HTTP status code %s), but returned no error messages',
					$response->status
				)
			);
		
		}
		
		
		private static function raise_invalid_error_message (\CivicInfoBC\HTTP\Response $response) {
		
			throw new \Exception(
				sprintf(
					'Canada Post reported error (HTTP status code %s), but returned invalid error message structure',
					$response->status
				)
			);
		
		}
		
		
		private static function get_message (\DOMNode $node) {
		
			$w=new \CivicInfoBC\DOMWrapper($node);
			
			try {
			
				if (
					(($code=$w->code->textContent)==='') ||
					(($desc=$w->description->textContent)==='')
				) return null;
			
			} catch (\Exception $e) {
			
				return null;
			
			}
			
			return sprintf('Code %s, %s',$code,$desc);
		
		}
		
		
		private static function raise (\CivicInfoBC\HTTP\Response $response) {
		
			//	Get XML document and make sure it
			//	has nodes
			$xml=new \CivicInfoBC\DOMWrapper(
				\CivicInfoBC\XML::Load($response->body)
			);
			
			//	Try and find the "messages" child
			if (is_null($messages=$xml->messages)) self::raise_no_error_messages($response);
			$messages=new \CivicInfoBC\DOMWrapper($messages,'message');
			
			//	Build a string from the children of the "messages"
			//	node
			$message=sprintf(
				'Canada Post error (HTTP status code %s): ',
				$response->status
			);
			$first=true;
			foreach ($messages as $element) {
			
				if ($first) $first=false;
				else $message.='; ';
				
				if (is_null($append=self::get_message($element))) self::raise_invalid_error_message($response);
				$message.=$append;
			
			}
			
			//	If no messages were found, throw
			if ($first) self::raise_no_error_messages($response);
			
			//	THROW
			throw new \Exception($message);
		
		}
		
		
		private static function check (\CivicInfoBC\HTTP\Response $response) {
		
			switch ($response->status) {
			
				//	This is actually success
				case 200:
				case 204:
				case 304:
					return;
					
				//	Parse error message structure
				default:
					self::raise($response);
			
			}
		
		}
		
		
		/**
		 *	Executes a request.
		 *
		 *	\param [in] $request
		 *		The request object which encapsulates
		 *		the request to perform.
		 *
		 *	\return
		 *		The result of executing \em request.
		 */
		public function Execute (Request $request) {
		
			//	Setup the request
			$this->request->url=$request->GetURL($this->production);
			$this->request->verb=$request->GetMethod();
			$this->request->headers['Accept']=$request->GetAccept();
			if (strtoupper($this->request->verb)==='POST') {

				$this->request->headers['Content-Type']=$request->GetContentType();
				$this->request->body=$request->GetBody();
				
			}
			
			//	Make the request
			$response=$this->request->Execute();
			
			//	Check to make sure it wasn't a Canada
			//	Post API error
			self::check($response);
			
			//	If nothing was returned, return null,
			//	otherwise use the request object to
			//	extract meaning from the response
			return ($response->body==='') ? null : $request->GetResponse(
				\CivicInfoBC\XML::Load($response->body)
			);
		
		}
	
	
	}


?>