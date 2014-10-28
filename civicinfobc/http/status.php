<?php


	namespace CivicInfoBC\HTTP;
	
	
	/**
	 *	An exception which encapsulates on
	 *	HTTP status code.
	 */
	class Status extends \Exception {
	
	
		private static $map=array(
			301 => array(
				'Moved Permenantly',
				'The content has been moved to a new, indicated location'
			),
			302 => array(
				'Found',
				'The content may be found in the indicated location'
			),
			400 => array(
				'Bad Request',
				'The request was poorly formed'
			),
			401 => array(
				'Unauthorized',
				'The requester does not have the appropriate permissions'
			),
			402 => array (
				'Payment Required',
				'Payment is required to proceed'
			),
			403 => array(
				'Forbidden',
				'The requester is not authorized'
			),
			404 => array(
				'Not Found',
				'The requested resource cannot be found or may not exist'
			),
			405 => array(
				'Method Not Allowed',
				'The HTTP method used to issue the request is not permitted'
			),
			406 => array(
				'Not Acceptable',
				'The received HTTP headers do not allow for the requested resource\'s content'
			),
			407 => array(
				'Proxy Authentication Required',
				'The requester must authenticate with the proxy before being allowed to proceed'
			),
			408 => array(
				'Request Timeout',
				'The request took too long'
			),
			409 => array(
				'Conflict',
				'The request has a conflict and therefore could not be processed'
			),
			410 => array(
				'Gone',
				'The requested resource is no longer at the given location'
			),
			411 => array(
				'Length Required',
				'The request requires a length, but one was not provided'
			),
			412 => array(
				'Precondition Failed',
				'The server does not meet a specified precondition'
			),
			413 => array(
				'Request Entity Too Large',
				'The request is too large'
			),
			414 => array(
				'Request-URI Too Long',
				'The request URI exceeds the acceptable lengeth'
			),
			415 => array(
				'Unsupported Media Type',
				'The request has a media type which the server or resource do not support'
			),
			416 => array(
				'Requested Range Not Satisfiable',
				'The server cannot supply the specified portion of the file'
			),
			417 => array(
			
			),
			418 => array(
				'I\'m a teapot',
				''
			),
			420 => array(
				'Enhance Your Calmn',
				'The requester has submitted too many requests and is being rate limited'
			),
			423 => array(
				'Locked',
				'The requested resource is locked'
			),
			424 => array(
				'Failed Dependency',
				'A previous request failed, so this request fails'
			),
			425 => array(
				'Unordered Collection',
				''
			),
			426 => array(
				'Upgrade Required',
				'The requester must switch to a different protocol'
			),
			428 => array(
				'Precondition Required',
				'The origin server requires this request to be conditional'
			),
			429 => array(
				'Too Many Requests',
				'The requester has submitted too many requests and is being rate limited'
			),
			431 => array(
				'Request Header Fields Too Large',
				'Due to the size of either the header fields, or the collection of header fields, this request will not proceed'
			),
			444 => array(
				'No Response',
				'Server has returned no content and closed the connection'
			),
			449 => array(
				'Retry With',
				'The request should be retried after performing the appropriate action'
			),
			450 => array(
				'Blocked by Windows Parental Controls',
				'Mommy or Daddy said no'
			),
			451 => array(
				'Unavailable for Legal Reasons',
				'The law does not permit this content to be displayed'
			),
			494 => array(
				'Request Header Too Large',
				'Due to the size of either the header fields, or the collection of header fields, this request will not proceed'
			),
			495 => array(
				'Cert Error',
				'SSL client certificate error'
			),
			496 => array(
				'No Cert',
				'Client did not provide a certificate'
			),
			497 => array(
				'HTTP to HTTPS',
				'An HTTP request was submitted to an HTTPS port'
			),
			499 => array(
				'Client Closed Request',
				'Client closed connection prematurely'
			),
			500 => array(
				'Internal Server Error',
				'An error occurred while processing the request'
			),
			501 => array(
				'Not Implemented',
				'Method not recognized or server cannot fulfill request'
			),
			502 => array(
				'Bad Gateway',
				'Invalid response received from the upstream server'
			),
			503 => array(
				'Service Unavailable',
				'The requested service is currently not available'
			),
			504 => array(
				'Gateway Timeout',
				'The upstream server did not respond in a timely manner'
			),
			505 => array(
				'HTTP Version Not Supported',
				'The version of the HTTP protocol used to make the request is not supported'
			),
			506 => array(
				'Variant Also Negotiates',
				'Transparent content negotiation for this request requests in a circular reference'
			),
			507 => array(
				'Insufficient Storage',
				'The server is unable to store the representation needed to complete this request'
			),
			508 => array(
				'Loop Detected',
				'An infinite loop was detected processing the request'
			),
			509 => array(
				'Bandwidth Limit Exceeded',
				'The client whose server the request was made to has exceeded their bandwidth allocation'
			),
			510 => array(
				'Not Extended',
				'In order for the request to fulfilled, further extensions to it will be required'
			),
			511 => array(
				'Network Authentication Required',
				'You must authenticate to the network to proceed'
			),
			598 => array(
				'Network Read Timeout Error',
				'A read behind the proxy timed out'
			),
			599 => array(
				'Network Connect Timeout Error',
				'An attempt to connect behind the proxy timed out'
			)
		);
		
		
		private static function lookup ($status) {
		
			$retr=new StatusInfo(
				$status,
				null,
				null
			);
			
			if (isset(self::$map[$status])) {
			
				$arr=self::$map[$status];
				
				$retr->name=$arr[0];
				$retr->message=$arr[1];
			
			}
			
			return $retr;
		
		}
	
	
		const MOVED_PERMENANTLY=301;
		const FOUND=302;
		const SEE_OTHER=303;
		const BAD_REQUEST=400;
		const UNAUTHORIZED=401;
		const FORBIDDEN=403;
		const NOT_FOUND=404;
		const SERVER_ERROR=500;
	
	
		/**
		 *	Creates a new HTTP status object.
		 *
		 *	\param [in] $status
		 *		The numerical HTTP status to associated
		 *		with this object.
		 *	\param [in] $prev
		 *		The previously thrown Exception which
		 *		caused this status, if applicable.
		 */
		public function __construct ($status, $prev=null) {
		
			parent::__construct(
				self::lookup($status)->message,
				$status,
				$prev
			);
		
		}
		
		
		/**
		 *	Retrieves an HTTPStatusInfo object describing
		 *	the status code encapsulated by this object.
		 *
		 *	\return
		 *		An HTTPStatusInfo object.
		 */
		public function Get () {
		
			return self::lookup($this->code);
		
		}
		
		
		/**
		 *	Sends the headers appropriate for this HTTP
		 *	status.
		 */
		public function Send () {
		
			header(
				sprintf(
					'%s %s %s',
					$_SERVER['SERVER_PROTOCOL'],
					$this->code,
					self::lookup($this->code)->name
				)
			);
		
		}
	
	
	}


?>