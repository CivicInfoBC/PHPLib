<?php


	namespace Tests;
	
	
	use \CivicInfoBC\Request as R;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class Request extends \CivicInfoBC\Testing\TestSuite {
	
	
		public function __construct () {
		
			parent::__construct('HTTP Request Utilities');
			
			$this->tester->tests=array(
				new T(
					'IsPost',
					'IsPost method properly reports that this is not a POST',
					function () {	return !R::IsPost();	}
				),
				new T(
					'GetHeaders',
					'GetHeaders properly returns HTTP headers (checks for host header)',
					function () {	return !is_null(R::GetHeaders()->Get('host'));	}
				),
				new T(
					'GetBody',
					'GetBody properly returns request body (empty string)',
					function () {	return R::GetBody()==='';	}
				)
			);
		
		}
	
	
	}


?>