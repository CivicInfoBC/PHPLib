<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains information about an HTTP status;
	 */
	class HTTPStatusInfo {
	
	
		/**
		 *	The numerical status code.
		 */
		public $code;
		/**
		 *	The name of the status code as it should
		 *	be sent in the response.
		 */
		public $name;
		/**
		 *	A descriptive message describing the error
		 *	this status code represents.
		 */
		public $message;
		
		
		public function __construct ($code, $name, $message) {
		
			$this->code=$code;
			$this->name=$name;
			$this->message=$message;
		
		}
	
	
	};


?>