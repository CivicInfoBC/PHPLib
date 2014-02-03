<?php


	namespace Tests;
	
	
	use \CivicInfoBC\HTML as H;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class HTML extends \CivicInfoBC\Testing\TestSuite {
	
	
		public function __construct () {
		
			parent::__construct('HTML Utilities');
			
			$this->tester->tests=array(
				new T(
					'Escape (identity)',
					'Escape leaves strings without HTML entities untouched',
					function () {
					
						$str='hello world';
						return H::Escape($str)===$str;
					
					}
				),
				new T(
					'Escape (identity, zero length)',
					'Escape escapes the empty string to the empty string',
					function () {	return H::Escape('')==='';	}
				),
				new T(
					'Escape',
					'Escape transforms HTML entities',
					function () {	return H::Escape('&<hello world>')==='&amp;&lt;hello world&gt;';	}
				),
				new T(
					'Escape (multiple inputs)',
					'Escapes properly escapes and concatenates multiple arguments',
					function () {	return H::Escape('&<','hello world','>')==='&amp;&lt;hello world&gt;';	}
				),
				new T(
					'Escape (arrays)',
					'Escape properly flattens arrays',
					function () {	return H::Escape(array('&','<','hello'),' ',array('world'),array('>'))==='&amp;&lt;hello world&gt;';	}
				)
			);
		
		}
	
	
	}


?>