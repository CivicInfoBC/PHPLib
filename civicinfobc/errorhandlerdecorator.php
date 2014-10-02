<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Implements the Decorator pattern for ErrorHandler objects.
	 */
	class ErrorHandlerDecorator extends ErrorHandler {
	
	
		private $inner;
		
		
		/**
		 *	Creates a new ErrorHandlerDecorator which decorates
		 *	some ErrorHandler.
		 *
		 *	\param [in] $inner
		 *		The ErrorHandler to decorate.  If \em null no
		 *		ErrorHandler will be decorated, and when this
		 *		object's Panic method is invoked, the script will
		 *		simply die.
		 */
		public function __construct (ErrorHandler $inner=null) {
		
			$this->inner=$inner;
		
		}
		
		
		public function Panic (\Exception $ex) {
		
			if (is_null($this->inner)) parent::Panic($ex);
			else $this->inner->Panic($ex);
		
		}
	
	
	}


?>