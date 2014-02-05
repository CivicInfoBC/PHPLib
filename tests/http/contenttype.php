<?php


	namespace Tests\HTTP;
	
	
	use \CivicInfoBC\HTTP\ContentType as C;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class ContentType extends \CivicInfoBC\Testing\TestSuite {
	
	
		public static function check ($header, $media_type, $charset) {
		
			$obj=new C($header);
			return ($obj->media_type===$media_type) && ($obj->charset===$charset);
		
		}
	
	
		public function __construct () {
		
			parent::__construct('HTTP Content-Type Header Parser');
			
			$this->tester->tests=array(
				new T(
					'Standard',
					'Parse standard Content-Type header (text/html; charset=utf-8)',
					function () {
					
						return ContentType::check(
							'text/html; charset=utf-8',
							'text/html',
							'utf-8'
						);
					
					}
				),
				new T(
					'No Whitespace',
					'Parse Content-Type header without whitespace (text/html;charset=utf-8)',
					function () {
					
						return ContentType::check(
							'text/html;charset=utf-8',
							'text/html',
							'utf-8'
						);
					
					}
				),
				new T(
					'No Character Set',
					'Parse Content-Type header with missing character set (text/html)',
					function () {
					
						return ContentType::check(
							'text/html',
							'text/html',
							null
						);
					
					}
				),
				new T(
					'Nothing',
					'Parse empty Content-Type header',
					function () {	return ContentType::check('',null,null);	}
				)
			);
		
		}
	
	
	}


?>