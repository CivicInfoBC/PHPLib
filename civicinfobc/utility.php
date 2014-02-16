<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains general utilities and quality
	 *	of life functions for doing general
	 *	tasks in PHP unrelated to any specific
	 *	task or data type in particular.
	 */
	class Utility {
	
	
		/**
		 *	Swaps two values.
		 *
		 *	\param [in,out] $a
		 *		A value.
		 *	\param [in,out] $b
		 *		A value.
		 */
		public static function Swap (&$a, &$b) {
		
			$temp=$b;
			$b=$a;
			$a=$temp;
		
		}
	
	
	}


?>