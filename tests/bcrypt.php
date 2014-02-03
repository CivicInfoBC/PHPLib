<?php


	namespace Tests;
	
	
	use \CivicInfoBC\bcrypt as b;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class bcrypt extends \CivicInfoBC\Testing\TestSuite {
	
	
		public function __construct () {
		
			parent::__construct('bcrypt');
			
			$this->tester->tests=array(
				new T(
					'Length',
					'bcrypt hash length is 60 characters',
					function () {
					
						$bcrypt=new b();
						return strlen($bcrypt->Hash('password'))===60;
					
					}
				),
				new T(
					'Format',
					'bcrypt hash has the correct format',
					function () {
					
						$bcrypt=new b(12);
						$hash=$bcrypt->Hash('password');
						return \CivicInfoBC\Regex::IsMatch(
							'/^\\$2a\\$12\\$[A-Za-z0-9\\.\\/]{53}$/u',
							$bcrypt->Hash('password')
						);
					
					}
				),
				new T(
					'Uniqueness',
					'Two hashes of the same password do not yield the same hash',
					function () {
					
						$bcrypt=new b();
						$p='password';
						return $bcrypt->Hash($p)!==$bcrypt->Hash($p);
					
					}
				),
				new T(
					'Verification (same passwords)',
					'bcrypt object verifies the password that generated a hash',
					function () {
					
						$bcrypt=new b();
						$p='password';
						return $bcrypt->Verify($p,$bcrypt->Hash($p));
					
					}
				),
				new T(
					'Verification (different passwords)',
					'bcrypt object does not verify a different password than the one which generated the hash',
					function () {
					
						$bcrypt=new b();
						return !$bcrypt->Verify('pass',$bcrypt->Hash('password'));
					
					}
				)
			);
		
		}
	
	
	}


?>