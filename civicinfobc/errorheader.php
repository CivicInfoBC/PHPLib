<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Handles errors by emitting HTTP headers.
	 */
	class ErrorHeader extends ErrorHandlerDecorator {
	
	
		public function Panic (\Exception $ex) {
		
			try {
			
				$e=$ex;
				if (!($e instanceof HTTP\Status)) $e=new HTTP\Status(HTTP\Status::SERVER_ERROR,$ex);
				
				$e->Send();
				
			} catch (\Exception $ignored) {	}
			
			parent::Panic($ex);
		
		}
	
	
	}


?>