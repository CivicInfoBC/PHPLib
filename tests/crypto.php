<?php


	namespace Tests;
	
	
	use \CivicInfoBC\Crypto as C;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class Crypto extends \CivicInfoBC\Testing\TestSuite {
	
	
		public function __construct () {
		
			parent::__construct('Cryptography Utilities');
			
			$this->tester->tests=array(
				new T(
					'PRNG (length)',
					'Pseudo-random number generator returns requested number of bytes',
					function () {
					
						$num=16;
						return strlen(C::Random($num,true))===$num;
						
					}
				),
				new T(
					'PRNG (zero bytes)',
					'Pseudo-random number generator returns zero bytes when requested',
					function () {
						
						$num=0;
						return strlen(C::Random($num))===$num;
						
					}
				)
			);
		
		}
	
	
	}


?>