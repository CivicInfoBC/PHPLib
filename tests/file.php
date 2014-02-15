<?php


	namespace Tests;
	
	
	use \CivicInfoBC\File as F;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class File extends \CivicInfoBC\Testing\TestSuite {
	
	
		private static $dne='dne';
		private static $file='./foo.txt';
		private static $put='foo';
	
	
		public function __construct () {
		
			parent::__construct('File Utilities');
			
			$this->tester->tests=array(
				new T(
					'GetLastModified',
					'Attempting to get the last modified date/time of a file works',
					function () {	return F::GetLastModified(__FILE__) instanceof \DateTime;	}
				),
				new T(
					'GetLastModified (failure)',
					'Attempting to get the last modified date/time of a non-existent file throws',
					function () {	F::GetLastModified(self::$dne);	},
					true
				),
				new T(
					'GetContents',
					'Getting the contents of a file works',
					function () {	return F::GetContents(__FILE__)!=='';	}
				),
				new T(
					'GetContents (failure)',
					'Getting the contents of a non-existent file throws',
					function () {	F::GetContents(self::$dne);	},
					true
				),
				new T(
					'Exists',
					'An extant file is confirmed as existing',
					function () {	return F::Exists(__FILE__);	}
				),
				new T(
					'Exists (failure)',
					'A non-existent file is not reported as existing',
					function () {	return !F::Exists(self::$dne);	}
				),
				new T(
					'Delete (failure)',
					'Attempting to delete a non-existent file fails',
					function () {	return !F::Delete(self::$dne);	}
				),
				new T(
					'PutContents',
					'Attempting to put contents to a file succeeds',
					function () {
					
						F::PutContents(self::$file,self::$put);
						
						return F::Exists(self::$file) && (F::GetContents(self::$file)===self::$put);
					
					}
				),
				new T(
					'PutContents (overwrite)',
					'Overwriting the contents of a file works',
					function () {
					
						F::PutContents(self::$file,self::$put);
						
						return F::Exists(self::$file) && (F::GetContents(self::$file)===self::$put);
					
					}
				),
				new T(
					'PutContents (append)',
					'Appending to a file works',
					function () {
					
						F::PutContents(self::$file,self::$put,false);
						
						return F::Exists(self::$file) && (F::GetContents(self::$file)===(self::$put.self::$put));
					
					}
				),
				new T(
					'Delete',
					'Deleting a file works',
					function () {	return F::Delete(self::$file) && !F::Exists(self::$file);	}
				),
				new T(
					'PutContents (failure)',
					'Attempting to write to a file with an illegal path fails',
					function () {	F::PutContents("\b",self::$put);	},
					true
				)
			);
		
		}
	
	
	}


?>