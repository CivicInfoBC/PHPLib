<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	An error handler which sends an e-mail when an error
	 *	occurs.
	 */
	class ErrorEMail extends ErrorHandlerDecorator {
	
	
		private $email;
		private $render;
		
		
		/**
		 *	Creates a new ErrorEMail object.
		 *
		 *	\param [in] $email
		 *		The EMail object to use to send e-mail.  If the subject is not
		 *		set, it will be set to an automatically generated subject.
		 *	\param [in] $render
		 *		The argument to pass through to the EMail object's Send method.
		 *		If this is an object, its \em ex property will be set to the
		 *		triggering exception prior to sending.
		 *	\param [in] $inner
		 *		An inner ErrorHandler to decorate.  If \em null no ErrorHandler
		 *		will be decorated.
		 */
		public function __construct (EMail $email, $render, ErrorHandler $inner=null) {
		
			parent::__construct($inner);
		
			$this->email=$email;
			$this->render=$render;
		
		}
		
		
		public function Panic (\Exception $ex) {
		
			try {
			
				if (is_null($this->email->subject)) $this->email->subject=sprintf(
					'%s: Error in script %s',
					$_SERVER['COMPUTERNAME'],
					$_SERVER['SCRIPT_FILENAME']
				);
				
				if (is_object($this->render)) $this->render->ex=$ex;
				
				$this->email->Send($this->render);
			
			} catch (\Exception $e) {	}
			
			parent::Panic($ex);
		
		}
	
	
	}


?>