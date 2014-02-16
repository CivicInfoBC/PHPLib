<?php


	namespace Tests;
	
	
	use \CivicInfoBC\Utility as U;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class Utility extends \CivicInfoBC\Testing\TestSuite {
	
	
		public function __construct () {
		
			parent::__construct('Utilities');
			
			$this->tester->tests=array(
				new T(
					'Swap',
					'Swap method swaps two values',
					function () {
					
						$a=5;
						$b='hello';
						U::Swap($a,$b);
						
						return (($b===5) && ($a==='hello'));
					
					}
				)
			);
		
		}
	
	
	}


?>