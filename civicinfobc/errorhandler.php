<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Derived classes provide mechanisms by which errors
	 *	may be handled.
	 */
	class ErrorHandler {
	
	
		/**
		 *	When overriden in a derived class, performs the
		 *	error action and exits.
		 *
		 *	Default implementation simply exits.
		 *
		 *	\param [in] ex
		 *		The exception which caused the panic.
		 */
		public function Panic (\Exception $ex) {
		
			exit();
		
		}
	
	
		/**
		 *	Guards a callback, invoking it and translating any
		 *	exceptions it may throw to a panic.
		 *
		 *	Any output the callback may generate is buffered until
		 *	it completes successfully.  Should it not complete
		 *	successfully this buffer is cleaned before the panic
		 *	action is taken.
		 *
		 *	\param [in] callback
		 *		The callback to invoke.
		 */
		public function Guard ($callback) {
		
			$ob=new OutputBuffer();
			
			try {
			
				$callback();
			
			} catch (\Exception $e) {
			
				$ob=null;
				
				try {
				
					$this->Panic($e);
					
				} catch (\Exception $ex) {	}
				
				exit();
			
			}
			
			$ob->Flush();
		
		}
	
	
	}


?>