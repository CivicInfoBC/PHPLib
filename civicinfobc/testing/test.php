<?php


	namespace CivicInfoBC\Testing;
	
	
	/**
	 *	Represents a single test to be run.
	 */
	class Test {
	
	
		private $name;
		private $desc;
		private $throws;
		private $callback;
		
	
		/**
		 *	Creates a new test.
		 *
		 *	\param [in] $name
		 *		The name of this test.
		 *	\param [in] $desc
		 *		A description of this test.
		 *	\param [in] $callback
		 *		A callable object which will
		 *		run this test.
		 *	\param [in] $throws
		 *		\em true if the test is meant to
		 *		throw, \em false otherwise.  Defaults
		 *		to \em false.
		 */
		public function __construct ($name, $desc, $callback, $throws=false) {
		
			$this->name=$name;
			$this->desc=$desc;
			$this->throws=$throws;
			$this->callback=$callback;
		
		}
		
		
		/**
		 *	Runs the test.
		 *
		 *	\return
		 *		A Result object containing the
		 *		result of running the test.
		 */
		public function Execute () {
		
			$retr=new Result();
			$retr->name=$this->name;
			$retr->description=$this->desc;
			
			try {
			
				$callback=$this->callback;
				$retr->result=$callback();
				$retr->success=!$this->throws && $retr->result;
			
			} catch (\Exception $e) {
			
				$retr->result=$e;
				$retr->success=$this->throws;
			
			}
			
			return $retr;
		
		}
	
	
	}


?>