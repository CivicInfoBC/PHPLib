<?php


	namespace CivicInfoBC\Testing;
	
	
	/**
	 *	A base class which test suites may extend.
	 */
	class TestSuite {
	
	
		/**
		 *	A tester.
		 */
		protected $tester;
		/**
		 *	The name of this test suite.
		 */
		protected $name;
	
	
		/**
		 *	Creates a new test suite.
		 *
		 *	\param [in] $name
		 *		The name of this test suite.
		 */
		protected function __construct ($name) {
		
			$this->tester=new Tester();
			$this->name=$name;
		
		}
		
		
		/**
		 *	Runs the test suite.
		 *
		 *	\return
		 *		A TestSuiteResult object which
		 *		contains the results of running
		 *		this test suite.
		 */
		public function Execute () {
		
			$retr=new TestSuiteResult();
			$retr->name=$this->name;
			$retr->results=$this->tester->Execute();
			
			return $retr;
		
		}
	
	
	}


?>