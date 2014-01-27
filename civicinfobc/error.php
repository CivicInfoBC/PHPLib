<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains error-handling functionality.
	 */
	class Error {
	
	
		/**
		 *	Converts a built in PHP error to an
		 *	exception.
		 *
		 *	Throws unconditionally.
		 */
		public static function Raise () {
		
			if (is_null($error=error_get_last())) throw new \Exception(
				'Error code returned by error_get_last returns no error'
			);
			
			throw new \Exception(
				$error['message'],
				$error['type']
			);
		
		}
	
	
	}


?>