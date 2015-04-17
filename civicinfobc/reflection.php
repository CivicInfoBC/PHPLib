<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains static methods to assist in reflection.
	 */
	class Reflection {
		
		
		/**
		 *	Provides a similar facility to the PHP built in function
		 *	gettype, except when faced with an object returns the name
		 *	of the object's class, rather than simply returning
		 *	&quot;object&quot;.
		 *
		 *	\param [in] $val
		 *		The value whose type shall be retrieved.
		 *
		 *	\return
		 *		A string containing the name of the type.
		 */
		public static function GetType ($val) {
			
			return is_object($val) ? get_class($val) : gettype($val);
			
		}
		
		
	}


?>