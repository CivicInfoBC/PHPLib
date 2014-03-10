<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for manipulating PHP objects.
	 */
	class ObjectUtil {
	
	
		/**
		 *	Merges objects, forming an object which is the union
		 *	of their key/value pairs.
		 *
		 *	If two keys which are identical are encountered, the
		 *	latter is taken.
		 *
		 *	An arbitrary number of objects may be passed.
		 *
		 *	\return
		 *		An object which is the union of all provided objects.
		 */
		public static function Merge () {
		
			$retr=new \stdClass();
			
			foreach (func_get_args() as $arg) $retr=(object)array_merge(
				(array)$retr,
				(array)$arg
			);
			
			return $retr;
		
		}
	
	
	}


?>