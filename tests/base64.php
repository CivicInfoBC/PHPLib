<?php


	namespace Tests;
	
	
	use \CivicInfoBC\Base64 as B;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class Base64 extends \CivicInfoBC\Testing\TestSuite {
	
	
		public function __construct () {
		
			parent::__construct('Base64 Encoder/Decoder');
			
			$this->tester->tests=array(
				new T(
					'Round Trip',
					'Base64 encoder successfully round trips strings',
					function () {
					
						$str='hello world';
						return B::Decode(B::Encode($str))===$str;
					
					}
				),
				new T(
					'Reject Invalid',
					'Base64 encoder rejects invalid base64 strings',
					function () {	B::Decode('?');	},
					true
				),
				new T(
					'Reject Whitespace',
					'Decode rejects strings containing whitespace where PHP\'s base64 decoder does not',
					function () {	B::Decode(' ');	},
					true
				)
			);
		
		}
	
	
	}


?>