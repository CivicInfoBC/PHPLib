<?php


	namespace CivicInfoBC\MySQL;
	
	
	/**
	 *	The result of a MySQL query which returns
	 *	results.
	 *
	 *	May be iterated to retrieve each row as
	 *	an object.  The properties of the object
	 *	will be converted to the appropriate PHP
	 *	type for their MySQL database type.
	 *
	 *	If count is applied to this object, it will
	 *	determine how many rows are in the result set.
	 */
	class Result implements \Countable, \Iterator {
	
	
		private $result;
		private $num=0;
		private $curr;
		
		
		private function extract ($field, $value) {
		
			//	We convert the value to an appropriate
			//	PHP type
			
			if (is_null($value)) return null;
			
			switch ($field->type) {
			
				//	Converts to float
				case MYSQLI_TYPE_DECIMAL:
				case MYSQLI_TYPE_NEWDECIMAL:
				case MYSQLI_TYPE_FLOAT:
				case MYSQLI_TYPE_DOUBLE:
					return floatval($value);
					
				//	Converts to int
				case MYSQLI_TYPE_BIT:
				case MYSQLI_TYPE_TINY:
				case MYSQLI_TYPE_SHORT:
				case MYSQLI_TYPE_LONG:
				case MYSQLI_TYPE_CHAR:
				case MYSQLI_TYPE_LONGLONG:
				case MYSQLI_TYPE_INT24:
					return intval($value);
					
				//	Converts to null (didn't we cover this
				//	above?  Included for completeness)
				case MYSQLI_TYPE_NULL:
					return null;
					
				//	Converts to string
				case MYSQLI_TYPE_ENUM:
				case MYSQLI_TYPE_SET:
				case MYSQLI_TYPE_TINY_BLOB:
				case MYSQLI_TYPE_MEDIUM_BLOB:
				case MYSQLI_TYPE_LONG_BLOB:
				case MYSQLI_TYPE_BLOB:
				case MYSQLI_TYPE_VAR_STRING:
				case MYSQLI_TYPE_STRING:
				//	Apparently this type is unimplemented?
				case MYSQLI_TYPE_INTERVAL:
				case MYSQLI_TYPE_GEOMETRY:
				default:
					return (string)$value;
					
				//	Converts to DateTime
				case MYSQLI_TYPE_TIMESTAMP:
				case MYSQLI_TYPE_DATE:
				case MYSQLI_TYPE_TIME:
				case MYSQLI_TYPE_DATETIME:
				case MYSQLI_TYPE_NEWDATE:
					return new \DateTime($value);
				
				//	Special conversion
				case MYSQLI_TYPE_YEAR:
					$year=intval($value);
					return ($year<100) ? ($year+1900) : $year;
				
			}
		
		}
		
		
		private function get () {
		
			//	Try and get the fields and the
			//	values
			if (
				(($fields=$this->result->fetch_fields())===false) ||
				is_null($values=$this->result->fetch_row())
			) {
			
				//	If the fields and values can't
				//	be retrieved, just fail the object
			
				$this->curr=null;
				
				return;
			
			}
			
			//	We have fields and values, convert them
			//	into a Row object
			$this->curr=new \CivicInfoBC\Object();
			for ($i=0;$i<count($fields);++$i) {
			
				$name=$fields[$i]->name;
				
				$this->curr->$name=$this->extract(
					$fields[$i],
					$values[$i]
				);
				
			}
		
		}
		
		
		public function __construct ($result) {
		
			$this->result=$result;
			
			//	Start us off in the first
			//	position
			$this->get();
		
		}
		
		
		public function current () {
		
			return $this->curr;
		
		}
		
		
		public function key () {
		
			return $this->num;
		
		}
		
		
		public function next () {
		
			$this->get();
			++$this->num;
		
		}
		
		
		public function rewind () {	}
		
		
		public function valid () {
		
			return !is_null($this->curr);
		
		}
		
		
		public function count () {
		
			return $this->result->num_rows;
		
		}
		
		
		/**
		 *	Retrieves the current row by merging it
		 *	with another object, and then advances
		 *	the cursor to the next row.
		 *
		 *	\param [in] $obj
		 *		The object into which the row shall
		 *		be merged.
		 */
		public function Fetch ($obj) {
		
			if (is_null($this->curr)) return;
			
			foreach ($this->curr as $key=>$value) $obj->$key=$value;
			
			$this->get();
		
		}
	
	
	}


?>