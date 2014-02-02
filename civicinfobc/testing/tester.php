<?php


	namespace CivicInfoBC\Testing;
	
	
	/**
	 *	Performs a series of tests.
	 */
	class Tester {
	
	
		/**
		 *	An array of Test objects to be
		 *	executed.
		 */
		public $tests=array();
		
		
		/**
		 *	Performs each test and returns the
		 *	result of each.
		 *
		 *	\return
		 *		An array of Result objects which
		 *		contain the result of running each
		 *		test.
		 */
		public function Execute () {
		
			$retr=array();
			foreach ($this->tests as $test) $retr[]=$test->Execute();
			
			return $retr;
		
		}
	
	
	}


?>