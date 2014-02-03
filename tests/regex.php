<?php


	namespace Tests;
	
	
	use \CivicInfoBC\Regex as R;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class Regex extends \CivicInfoBC\Testing\TestSuite {
	
	
		public function __construct () {
		
			parent::__construct('Regular Expressions');
			
			$this->tester->tests=array(
				new T(
					'Invalid Pattern',
					'Regular expression wrapper throws on invalid pattern',
					function () {	R::IsMatch('/^hello world$','hello world');	},
					true
				),
				new T(
					'Escape',
					'Escape method works correctly',
					function () {	return R::Escape('hello, how are you?  (he was fine)')==='hello, how are you\\?  \\(he was fine\\)';	}
				),
				new T(
					'Replace',
					'Replace method works correctly',
					function () {	return R::Replace('/\\//u','\\','/hi/')==='\\hi\\';	}
				),
				new T(
					'ReplaceCallback',
					'ReplaceCallback method works correctly',
					function () {
					
						return R::ReplaceCallback(
							'/bar/u',
							function ($m) {	return 'foo';	},
							'barbarbar'
						)==='foofoofoo';
					
					}
				),
				new T(
					'IsMatch',
					'IsMatch method works correctly',
					function () {	return R::IsMatch('/^.*$/u','hello world');	}
				),
				new T(
					'Match',
					'Match method works correctly',
					function () {
					
						$match=R::Match('/^(.*)$/u','hello world');
						return !is_null($match) && ($match[1]==='hello world');
					
					}
				),
				new T(
					'Count',
					'Count method works correctly',
					function () {	return R::Count('/./u','hello world')===11;	}
				),
				new T(
					'Matches',
					'Matches method works correctly',
					function () {
					
						$matches=R::Matches('/(.)/u','hi');
						return (
							(count($matches)===2) &&
							($matches[0][1]==='h') &&
							($matches[1][1]==='i')
						);
					
					}
				),
				new T(
					'Split',
					'Split method works correctly',
					function () {
					
						$split=R::Split('/,/','billy,bobby,janey');
						return (
							count($split===3) &&
							($split[0]==='billy') &&
							($split[1]==='bobby') &&
							($split[2]==='janey')
						);
					
					}
				),
				new T(
					'Unicode',
					'Regular expressions work correctly for UTF-8 patterns and inputs on this platform',
					function () {
					
						//	The input string is wrapped in Unicode
						//	NBSP (U+00A0) characters
						return R::Replace(
							'/\\s/u',
							'',
							' Margaret '
						)==='Margaret';
					
					}
				)
			);
		
		}
	
	
	}


?>