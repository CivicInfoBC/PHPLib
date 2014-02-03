<?php


	namespace CivicInfoBC\Testing;
	
	
	/**
	 *	The result of a single test.
	 */
	class Result {
	
	
		/**
		 *	The name of the test, if one was supplied.
		 */
		public $name;
		/**
		 *	The description of the test, if one was supplied.
		 */
		public $description;
		/**
		 *	Whether the test succeeded or not.
		 */
		public $success;
		/**
		 *	What the result of running the test actually was.
		 */
		public $result;
	
	
	}


?>