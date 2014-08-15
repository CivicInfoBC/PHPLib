<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Provides optional options in registering participants for
	 *	events.
	 */
	class EventRegisterOptions {
	
	
		/**
		 *	An array giving the names of the columns
		 *	to check for duplicates in checking if
		 *	the participant being registered is already
		 *	registered.  Defaults to an array containing
		 *	\"firstname\" and \"lastname\".
		 */
		public $verify=array('firstname','lastname');
		/**
		 *	If \em true all SQL string comparisons shall
		 *	be done in a case insensitive manner.  Defaults
		 *	to \em true.
		 */
		public $case_insensitive=true;
		/**
		 *	If \em true registrations shall be allowed to
		 *	exceed the capacity.  Defaults to \em false.
		 */
		public $exceed_capacity=false;
	
	
	}


?>