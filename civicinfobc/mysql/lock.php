<?php


	namespace CivicInfoBC\MySQL;
	
	
	/**
	 *	An RAII wrapper for a MySQL table
	 *	lock.
	 */
	class Lock {
	
	
		private $conn;
		
		
		private static function get_list (array $arr) {
		
			$str='';
			$args=array();
			foreach ($arr as $x) {
			
				if ($str!=='') $str.=',';
				
				if (is_array($x)) {
				
					$obj=self::get_list($x);
					$str.=$obj->str;
					$args=array_merge(
						$args,
						$obj->args
					);
					
					continue;
					
				}
				
				if (!($x instanceof LockInfo)) $x=new LockInfo($x);
				
				$str.='%s '.($x->write ? 'WRITE' : 'READ');
				$args[]=$x->table;
			
			}
			
			$retr=new \stdClass();
			$retr->str=$str;
			$retr->args=$args;
			return $retr;
		
		}
		
		
		/**
		 *	Acquires a MySQL table lock.
		 *
		 *	An arbitrary number of extra arguments
		 *	may be passed.  They specify the locks
		 *	to acquire.
		 *
		 *	If strings or Name objects are passed,
		 *	a LockInfo object will be constructed
		 *	without specifying what kind of lock to
		 *	acquire, and the default lock for that
		 *	object will be acquired.
		 *
		 *	If a LockInfo object is passed, that
		 *	lock will be acquired.
		 *
		 *	\param [in] $conn
		 *		The MySQL Connection to use to acquire
		 *		the lock.
		 */
		public function __construct (Connection $conn) {
		
			$this->conn=$conn;
		
			$arr=func_get_args();
			unset($arr[0]);
			$list=self::get_list($arr);
			if (count($list->args)===0) throw new \Exception(
				'No tables specified'
			);
			
			call_user_func_array(
				array(
					$conn,
					'Execute'
				),
				array_merge(
					array('LOCK TABLES '.$list->str),
					$list->args
				)
			);
		
		}
		
		
		/**
		 *	Release a MySQL table lock.
		 */
		public function __destruct () {
		
			try {
			
				$this->conn->Execute('UNLOCK TABLES');
			
			//	IGNORE, nothing we can do
			//	about it in a destructor
			} catch (\Exception $e) {	}
		
		}
	
	
	}


?>