<?php


	namespace CivicInfoBC\MySQL;
	
	
	class LockInfo {
	
	
		public $table;
		public $write;
		
		
		public function __construct ($table, $write=true) {
		
			if (!($table instanceof Name)) $table=new Name($table);
			
			$this->table=$table;
			$this->write=$write;
		
		}
	
	
	}


?>