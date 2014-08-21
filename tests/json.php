<?php


	namespace Tests;
	
	
	use \CivicInfoBC\File as J;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class JSON extends \CivicInfoBC\Testing\TestSuite {
	
	
		//	This is taken directly from json.org
		private static $good='{
			"glossary": {
				"title": "example glossary",
				"GlossDiv": {
					"title": "S",
					"GlossList": {
						"GlossEntry": {
							"ID": "SGML",
							"SortAs": "SGML",
							"GlossTerm": "Standard Generalized Markup Language",
							"Acronym": "SGML",
							"Abbrev": "ISO 8879:1986",
							"GlossDef": {
								"para": "A meta-markup language, used to create markup languages such as DocBook.",
								"GlossSeeAlso": ["GML", "XML"]
							},
							"GlossSee": "markup"
						}
					}
				}
			}
		}';
	
	
		private static $dne='dne';
		private static $file='./foo.txt';
		private static $put='foo';
	
	
		public function __construct () {
		
			parent::__construct('JSON Utilities');
			
			$this->tester->tests=array(
				new T(
					'GetLastModified',
					'Attempting to get the last modified date/time of a file works',
					function () {	return F::GetLastModified(__FILE__) instanceof \DateTime;	}
				)
			);
		
		}
	
	
	}


?>