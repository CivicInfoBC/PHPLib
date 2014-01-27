<?php


	namespace CivicInfoBC\MySQL;
	
	
	/**
	 *	Encapsulates a MySQL database name.
	 *
	 *	Provides proper escaping when cast or
	 *	coerced to a string.
	 */
	class Name {
	
	
		private $name;
		
		
		/**
		 *	Creates a new MySQL database name.
		 *
		 *	\param [in] $name
		 *		The database name to escape.
		 */
		public function __construct ($name) {
		
			$this->name=$name;
		
		}
		
		
		private function escape ($name) {
		
			return '`'.Regex::Replace(
				'/`/u',
				'``',
				$name
			).'`';
		
		}
		
		
		/**
		 *	Converts the name to a string, escaping
		 *	it.
		 *
		 *	\return
		 *		The stored name, escaped in such a
		 *		way that it is safe to insert into
		 *		a MySQL query for use in naming a
		 *		database, table, or column.
		 */
		public function __toString () {
		
			if (is_array($this->name)) {
			
				$retr='';
				foreach ($this->name as $x) {
				
					if ($retr!=='') $retr.='.';
					
					$retr.=$this->escape($x);
				
				}
				
				return $retr;
				
			}
			
			return $this->escape($this->name);
		
		}
	
	
	}


?>