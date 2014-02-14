<?php


	namespace Tests;
	
	
	use \CivicInfoBC\PostalCode as P;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class PostalCode extends \CivicInfoBC\Testing\TestSuite {
	
	
		public function __construct () {
		
			parent::__construct('Postal Codes');
			
			$this->tester->tests=array(
				new T(
					'Normalize',
					'Normalizing removes unwanted characters and converts the string to uppercase',
					function () {	return P::Normalize(' v9a-2l8 ')==='V9A2L8';	}
				),
				new T(
					'Normalize (failure, illegal character)',
					'Normalizing a string with an impermissible character throws',
					function () {	P::Normalize('2l?8');	},
					true
				),
				new T(
					'Normalize (failure, illegal sequence)',
					'Normalizing a string with an otherwise-permissible character in an illegal position throws',
					function () {	P::Normalize('-2l8');	},
					true
				),
				new T(
					'Normalize (failure, empty string)',
					'Normalizing the empty string throws',
					function () {	P::Normalize('');	},
					true
				),
				new T(
					'Normalize (failure, too long)',
					'Normalizing a postal code that is too long throws',
					function () {	P::Normalize('01234567890');	},
					true
				),
				new T(
					'Normalize (failure, too short)',
					'Normalizing a postal code that is too short throws',
					function () {	P::Normalize('0');	},
					true
				),
				new T(
					'Verify',
					'A string containing a valid postal code verifies',
					function () {	return P::Verify(' v9a-2l8 ');	}
				),
				new T(
					'Verify (failure)',
					'A string containing an invalid postal code does not verify',
					function () {	return !P::Verify('2l?8');	}
				),
				new T(
					'IsCanadian',
					'Canadian postal codes are identified as such',
					function () {
					
						$obj=new P(' v9a-2l8 ');
						return $obj->IsCanadian();
					
					}
				),
				new T(
					'IsCanadian (failure)',
					'Non-Canadian postal codes are not identified as being Canadian',
					function () {
					
						$obj=new P('3028');
						return !$obj->IsCanadian();
					
					}
				),
				new T(
					'IsCanadian (failure, illegal letter)',
					'Postal codes which could otherwise be Canadian, but contain a letter not used by Canadian postal codes, are not identified as Canadian',
					function () {
					
						$obj=new P('D1Q5U6');
						return !$obj->IsCanadian();
					
					}
				),
				new T(
					'IsCanadian (failure, illegal start)',
					'Postal codes which could otherwise be Canadian, but start with a letter Canadian postal codes do not start with, are not identified as Canadian',
					function () {
					
						$obj=new P('W9A2L8');
						return !$obj->IsCanadian();
					
					}
				),
				new T(
					'IsAmerican',
					'American zip codes are identified as such',
					function () {
					
						$obj=new P('50258');
						return $obj->IsAmerican();
					
					}
				),
				new T(
					'IsAmerican',
					'Postal codes which are not American are not identified as such',
					function () {
					
						$obj=new P('3028');
						return !$obj->IsAmerican();
					
					}
				),
				new T(
					'String Conversion',
					'Postal codes are properly normalized (by the constructor) and converted to strings by the __toString magic method',
					function () {
					
						$obj=new P(' v9a-2l8 ');
						return ((string)$obj)==='V9A2L8';
					
					}
				)
			);
		
		}
	
	
	}


?>