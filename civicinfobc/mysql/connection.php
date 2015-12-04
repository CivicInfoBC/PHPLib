<?php


	namespace CivicInfoBC\MySQL;
	
	
	/**
	 *	A connection to a MySQL server.
	 */
	class Connection {
	
	
		//	Character sets in order of
		//	descending preference
		private static $charsets=array(
			'utf8mb4',
			'utf8',
			'latin1',
			'ascii'
		);
	
	
		private $mysqli;
		
		
		/**
		 *	Connects to a MySQL server.
		 *
		 *	\param [in] $ep
		 *		The endpoint to which a connection
		 *		should be formed.
		 */
		public function __construct ($ep=null) {
		
			//	Get a valid endpoint if we
			//	weren't given one
			if (
				is_null($ep) ||
				!($ep instanceof Endpoint)
			) $ep=new Endpoint();
			
			//	Create a connection
			$this->mysqli=new \mysqli(
				$ep->host,
				$ep->username,
				$ep->password,
				$ep->database,
				$ep->port
			);
			
			//	Check for a connection error
			if (!is_null($this->mysqli->connect_error)) throw new Exception(
				$this->mysqli->connect_error,
				$this->mysqli->connect_errno
			);
			
			//	Attempt to select a character
			//	set
			//
			//	Note that in order for real_escape_string
			//	to be secure, THIS MUST BE CALLED
			//	AT LEAST ONCE:
			//
			//	http://ca1.php.net/manual/en/mysqli.real-escape-string.php
			$set_charset=false;
			//	Yes, I'm using the evil @ character to silence
			//	warnings etc..  MySQL reports failure by
			//	returning false, but for some reason PHP feels
			//	the need to issue a warning if the request fails.
			//
			//	I have a bunch of fallback character sets FOR
			//	A REASON (because utf8mb4 is preferable, but requires
			//	a new-ish version of MySQL), and I throw when ALL
			//	the set_charset calls fail FOR A REASON, I don't need
			//	PHP's warning.
			foreach (self::$charsets as $x) if (@$this->mysqli->set_charset($x)) {
			
				$set_charset=true;
				
				break;
			
			}
			
			if (!$set_charset) throw new Exception('Failed to set MySQL character set');
		
		}
		
		
		public function __destruct () {
		
			//	Close the connection
			$this->mysqli->close();
		
		}
		
		
		/**
		 *	Escapes a value for use in a MySQL
		 *	query.
		 *
		 *	\param [in] $value
		 *		The value to escape.
		 *
		 *	\return
		 *		An escaped string for use in a MySQL
		 *		query.
		 */
		public function Escape ($value) {
		
			if (is_null($value)) return 'NULL';
			
			if (is_int($value)) return (string)$value;
			
			if (
				($value instanceof Name) ||
				($value instanceof Literal)
			) return (string)$value;
			
			if (is_bool($value)) return $value ? '1' : '0';
			
			if ($value instanceof \DateTime) $value=$value->format('Y-m-d H:i:s');
			
			return '\''.$this->mysqli->real_escape_string($value).'\'';
		
		}
		
		
		/**
		 *	Executes a query.
		 *
		 *	\param [in] $text
		 *		The text of the query in a format
		 *		acceptable for use in sprintf.  Extra
		 *		arguments may be passed to the function,
		 *		in which case they will be escaped and
		 *		substituted into this string with sprintf
		 *		before the query is executed.
		 *
		 *	\return
		 *		If \em text returned results, a Result
		 *		object.  Otherwise nohting.
		 */
		public function Execute ($text) {
		
			//	Process all the arguments
			//	to substitute into $text
			$arr=array();
			$arr[]=func_get_arg(0);
			for ($i=1;$i<func_num_args();++$i) $arr[]=$this->Escape(func_get_arg($i));
			
			//	Execute query
			if (($result=$this->mysqli->query(
				(count($arr)===1) ? $text : call_user_func_array(
					'sprintf',
					$arr
				)
			))===false) throw new Exception(
				$this->mysqli->error,
				$this->mysqli->errno
			);
			
			//	If the result is a boolean,
			//	the query wasn't SELECT, SHOW,
			//	DESCRIBE, or EXPLAIN, so return
			if (is_bool($result)) return;
			
			return new Result($result);
		
		}
		
		
		private function fix_name ($name) {
		
			return ($name instanceof Name) ? $name : new Name($name);
		
		}
		
		
		/**
		 *	Perfoms an UPDATE query.
		 *
		 *	\param [in] $table_name
		 *		The name of the table to update.
		 *	\param [in] $key_column
		 *		The name of the column which should be
		 *		used in the WHERE clause of the query.
		 *	\param [in] $values
		 *		An object which may be iterated to obtain
		 *		the key/value mapping for the values to be
		 *		set on the row-in-question.  The value with
		 * 		a key which matches \em key_column will be
		 *		used in the WHERE clause rather than the SET
		 *		clause.
		 */
		public function Update ($table_name, $key_column, $values) {
			
			//	Build SET and WHERE
			$set='';
			$where=null;
			$count=0;
			foreach ($values as $key=>$value) {
			
				$str=sprintf(
					'%s=%s',
					$this->fix_name($key),
					$this->Escape($value)
				);
				
				if (\CivicInfoBC\StringUtil::Equals($key,$key_column)) {
				
					$where.=$str;
					
				} else {
				
					if ($set!=='') $set.=',';
					$set.=$str;
					++$count;
				
				}
			
			}
			
			if ($count===0) throw new \Exception('Must be at least one non-key value');
			
			//	Check to make sure key column was found
			if (is_null($where)) throw new \Exception('Key column not found');
			
			//	Execute query
			$this->Execute(
				sprintf(
					'UPDATE %s SET %s WHERE %s',
					$this->fix_name($table_name),
					$set,
					$where
				)
			);
		
		}
		
		
		/**
		 *	Performs an INSERT query.
		 *
		 *	\param [in] $table_name
		 *		The name of the table to insert into.
		 *	\param [in] $obj
		 *		An object which may be iterated to obtain
		 *		the key/value mapping for the values to be
		 *		inserted.
		 *
		 *	\return
		 *		The ID of the inserted row, if the
		 *		table-in-question uses an automatically
		 *		generated key.
		 */
		public function Insert ($table_name, $obj) {
		
			//	Build keys and values
			$keys='';
			$values='';
			foreach ($obj as $key=>$value) {
			
				if ($keys!=='') {
				
					$keys.=',';
					$values.=',';
				
				}
			
				$keys.=$this->fix_name($key);
				$values.=$this->Escape($value);
			
			}
			
			//	Execute query
			$this->Execute(
				sprintf(
					'INSERT INTO %s (%s) VALUES (%s)',
					$this->fix_name($table_name),
					$keys,
					$values
				)
			);
			
			//	Return the auto generated id (if present)
			//	to the caller
			return $this->mysqli->insert_id;
		
		}
	
	
	}


?>