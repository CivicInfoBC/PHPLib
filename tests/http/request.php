<?php


	namespace Tests\HTTP;
	
	
	use \CivicInfoBC\HTTP\Request as R;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class Request extends \CivicInfoBC\Testing\TestSuite {
	
	
		public static $url='http://rleahy.ca/libcibc/';
	
	
		public static function perform ($url) {
		
			$request=new R($url);
			return $request->Execute();
		
		}
		
		
		public static function check_encoding ($charset) {
		
			return Request::perform(
				self::$url.'request_test.php?encoding='.\CivicInfoBC\URL::Escape($charset)
			)->GetBody()==='naïveté';
		
		}
	
	
		public function __construct () {
		
			parent::__construct('HTTP Request (libcurl Wrapper)');
			
			$this->tester->tests=array(
				new T(
					'Basic',
					'Basic HTTP request may be made successfully',
					function () {	return Request::perform('http://www.civicinfo.bc.ca/')->status===200;	}
				),
				new T(
					'Body',
					'ASCII encoded body may be recovered successfully',
					function () {	return Request::perform(Request::$url.'request_test.txt')->GetBody()==='test';	}
				),
				new T(
					'Body',
					'UTF-8 encoded body may be recovered successfully',
					function () {	return Request::check_encoding('utf-8');	}
				),
				new T(
					'Body',
					'UTF-16 encoded body may be recovered successfully',
					function () {	return Request::check_encoding('utf-16');	}
				),
				new T(
					'DNS Error',
					'Request for non-existent domain throws',
					function () {	Request::perform('http://test.nxdomain');	},
					true
				),
				new T(
					'Status Code',
					'Request for non-existent file returns appropriate status code',
					function () {	return Request::perform(Request::$url.'file_does_not_exist.txt')->status===404;	}
				),
				new T(
					'HTTP Version Numbers',
					'HTTP version numbers scraped from response are correct',
					function () {
					
						$response=Request::perform('http://www.civicinfo.bc.ca/');
						return ($response->major_version===1) && ($response->minor_version===1);
					
					}
				)
			);
		
		}
	
	
	}


?>