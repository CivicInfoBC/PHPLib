<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Represents a problem with a JSON
	 *	object.
	 */
	class JSONValidateResult {
	
	
		/**
		 *	The location in the JSON object at
		 *	which the problem was encountered.
		 */
		public $stack=array();
		/**
		 *	What the validator expected.
		 *
		 *	May be \em null.  This indicates that
		 *	the validator didn't expect to find
		 *	anything.
		 */
		public $expected;
		/**
		 *	What the validator actually found.
		 *
		 *	May be \em null.  This indicates that
		 *	the validator didn't find anything.
		 */
		public $got;
		
		
		/**
		 *	\cond
		 */
		
		
		public function __construct (array $stack, $expected, $got) {
		
			$this->stack=$stack;
			$this->expected=$expected;
			$this->got=$got;
		
		}
		
		
		/**
		 *	\endcond
		 */
	
	
	}


?>