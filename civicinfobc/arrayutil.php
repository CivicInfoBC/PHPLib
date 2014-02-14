<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for performing operations
	 *	on arrays.
	 */
	class ArrayUtil {
	
	
		/**
		 *	Checks an array to see if it contains
		 *	some element.
		 *
		 *	\param [in] $arr
		 *		The array.
		 *	\param [in] $what
		 *		The element.
		 *	\param [in] $comparer
		 *		An optional callable object which will
		 *		be used to compare objects for equality.
		 *		Defaults to \em null.  If \em null
		 *		strict comparison will be used.
		 *
		 *	\return
		 *		\em true if \em what is in \em arr,
		 *		\em false otherwise.
		 */
		public static function In ($arr, $what, $comparer=null) {
		
			if (!is_array($arr)) $arr=array($arr);
		
			if (is_null($comparer)) return in_array($what,$arr,true);
			
			foreach ($arr as $x) if ($comparer($x,$what)) return true;
			
			return false;
		
		}
	
	
	}


?>