<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for manipulating
	 *	and identifying the underlying operating
	 *	system platform and PHP runtime.
	 */
	class Platform {
	
	
		/**
		 *	Checks to see if the operating system
		 *	PHP is running on is Windows.
		 *
		 *	\return
		 *		\em true if PHP is running on
		 *		Microsoft Windows, \em false
		 *		otherwise.
		 */
		public static function IsWindows () {
		
			return Regex::IsMatch(
				'/^win/ui',
				PHP_OS
			);
		
		}
	
	
	}


?>