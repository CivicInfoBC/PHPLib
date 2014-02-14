<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for performing operations
	 *	on arrays.
	 */
	class ArrayUtil {
	
	
		/**
		 *	Coalesces a value to an array.
		 *
		 *	If the value is not an array, a new array
		 *	containing it as the only element will be
		 *	created and returned.
		 *
		 *	\param [in] $arr
		 *		The array or value.
		 *
		 *	\return
		 *		The coalesced value.
		 */
		public static function Coalesce ($arr) {
		
			return is_array($arr) ? $arr : array($arr);
		
		}
		
		
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
		
			$arr=self::Coalesce($arr);
		
			if (is_null($comparer)) return in_array($what,$arr,true);
			
			foreach ($arr as $x) if ($comparer($x,$what)) return true;
			
			return false;
		
		}
	
	
	}


?>