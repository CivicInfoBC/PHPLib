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
		
		
		/**
		 *	Wraps a callback, transforming any PHP warnings
		 *	or errors which occur during that callback into
		 *	exceptions which will be thrown when the callback
		 *	returns.
		 *
		 *	An arbitrary number of arguments may be passed in.
		 *	Any arguments past the first will be passed through
		 *	as arguments to the callback.
		 *
		 *	\param [in] $callback
		 *		The callback to invoke.
		 *
		 *	\return
		 *		Whatever \em callback returned, if anything.
		 */
		public static function Wrap ($callback) {
		
			$arr=func_get_args();
			unset($arr[0]);
			
			$ex=null;
			set_error_handler(function ($errno, $errstr) use (&$ex) {
			
				if (error_reporting()===0) return false;
			
				$ex=new \Exception($errstr,$errno);
				
				return true;
			
			});
			
			try {
			
				$retr=call_user_func_array($callback,$arr);
			
			} catch (\Exception $e) {
			
				restore_error_handler();
				
				throw $e;
			
			}
			
			restore_error_handler();
			
			if (!is_null($ex)) throw $ex;
			
			return $retr;
		
		}
	
	
	}


?>