<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	An HTTP 3xx status code.
	 */
	class Redirect extends HTTPStatus {
	
	
		public $location;
	
	
		/**
		 *	Creates a new Redirect.
		 *
		 *	\param [in] $location
		 *		The location to which the redirect
		 *		should send the client.
		 *	\param [in] $status
		 *		The HTTP status associated with this
		 *		redirect.  Defaults to 302 Found.
		 *	\param [in] $prev
		 *		The previous Exception object which
		 *		cause this status, if applicable.
		 */
		public function __construct ($location, $status=HTTPStatus::Found, $prev=null) {
		
			$this->location=$location;
			
			parent::__construct(
				$status,
				$prev
			);
		
		}
		
		
		public function Send () {
		
			//	Send the status code etc.
			parent::Send();
			
			//	Send the location header
			header('Location: '.$this->location);
		
		}
	
	
	};


?>