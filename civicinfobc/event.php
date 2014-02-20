<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	The base class for all CivicInfoBC
	 *	events.
	 */
	class Event implements \Countable {
	
	
		/**
		 *	The ID of this event.
		 */
		protected $id;
		/**
		 *	A database connection to the civinfo
		 *	database.
		 */
		protected $admin;
		/**
		 *	A database connection to the civicevents
		 *	database.
		 */
		protected $events;
		private $data;
		
		
		private function get ($key) {
		
			//	If the data is not available, fetch it
			//	from the database
			if (is_null($this->data)) {
			
				$result=$this->admin->Execute(
					'SELECT * FROM `event_reg_details` WHERE `regid`=%s',
					$this->id
				);
				if (count($result)===0) throw new \Exception(
					sprintf(
						'No event with ID %s',
						$this->id
					)
				);
				$this->data=$result->current();
			
			}
			
			if (!isset($this->data->$key)) return null;
			
			$retr=$this->data->$key;
			
			if (is_string($retr)) {
			
				$retr=String::Trim($retr);
				
				if ($retr==='') return null;
				
			}
			
			return $retr;
		
		}
		
		
		public function __isset ($key) {
		
			return !is_null($this->get($key));
		
		}
		
		
		public function __get ($key) {
		
			return $this->get($key);
		
		}
		
		
		/**
		 *	Creates a new Event.
		 *
		 *	\param [in] $id
		 *		The ID of this event.
		 *	\param [in] $admin
		 *		A database connection to the
		 *		civinfo database.
		 *	\param [in] $events
		 *		A database connection to the
		 *		civicevents database.
		 */
		public function __construct ($id, MySQL\Connection $admin, MySQL\Connection $events) {
		
			$this->id=$id;
			$this->admin=$admin;
			$this->events=$events;
		
		}
		
		
		private function get_table_name_plain () {
		
			if (!isset($this->billdbtable)) throw new \Exception(
				'`billdbtable` is null'
			);
			
			return $this->billdbtable;
		
		}
		
		
		private function get_table_name () {
		
			return new MySQL\Name($this->get_table_name_plain());
		
		}
		
		
		/**
		 *	Determines the number of participants
		 *	currently registered for this event.
		 *
		 *	\return
		 *		The number of participants currently
		 *		registered for this event.
		 */
		public function count () {
		
			foreach ($this->events->Execute(
				'SELECT COUNT(*) AS `count` FROM %s',
				$this->get_table_name()
			) as $x) return $x->count;
			
			return 0;
		
		}
		
		
		private function check_count () {
		
			return !isset($this->maxParticipants) || ($this->count()<$this->maxParticipants);
		
		}
		
		
		/**
		 *	Determines whether a registration is
		 *	open or not.
		 *
		 *	\param [in] $backdoor
		 *		The backdoor for this registration,
		 *		if any.  Defaults to \em null which
		 *		means to backdoor.
		 *
		 *	\return
		 *		\em true if this registration is open,
		 *		\em false otherwise.
		 */
		public function IsOpen ($backdoor=null) {
		
			//	Determine if the registration is open
			//	because of the backdoor
			if (
				isset(Request::$get->backdoor) &&
				!is_null($backdoor) &&
				String::Equals(
					$backdoor,
					Request::$get->backdoor
				)
			) return true;
			
			//	Determine if the registration is even
			//	open
			
			//	If the registration status is closed,
			//	the event is closed
			if (
				isset($this->regStatus) &&
				String::Equals(
					'CLOSED',
					String::ToUpper($this->regStatus)
				)
			) return false;
			
			//	If the current time is outside the start/end
			//	dates, the event is closed
			$curr=time();
			if (
				(
					isset($this->regstartdate) &&
					($this->regstartdate->getTimestamp()>$curr)
				) ||
				(
					isset($this->regenddate) &&
					($this->regenddate->getTimestamp()<$curr)
				)
			) return false;
			
			//	If there are more participants than allowed,
			//	the event is closed
			return $this->check_count();
		
		}
		
		
		/**
		 *	Checks to see if a participant identified in
		 *	a particular manner has already been registered.
		 *
		 *	\param [in] $participant
		 *		An object which may be iterated.  The keys
		 *		shall give the columns to match, the values
		 *		shall give the values to match.
		 *	\param [in] $case_insensitive
		 *		If \em true all SQL string comparisons shall
		 *		be done in a case insensitive manner.  Defaults
		 *		to \em true.
		 *
		 *	\return
		 *		\em true if the participant identified by
		 *		\em participant is already registered,
		 *		\em false otherwise.
		 */
		public function IsRegistered ($participant, $case_insensitive=true) {
		
			//	Generate WHERE clause
			$where_clause='';
			$args=array();
			foreach ($participant as $key=>$value) {
			
				if ($where_clause!=='') $where_clause.=' AND ';
				
				$args[]=new MySQL\Name($key);
				
				if (is_null($value)) {
				
					$where_clause.='%s IS NULL';
				
				} else {
				
					$args[]=$value;
					
					$where_clause.=(
						$case_insensitive &&
						is_string($value)
					) ? 'UPPER(%s)=UPPER(%s)' : '%s=%s';
				
				}
			
			}
			
			//	If no fields were provided, throw
			if ($where_clause==='') throw new \Exception(
				'No fields on which to match rows'
			);
			
			//	Perform the SQL query
			foreach (call_user_func_array(
				array(
					$this->events,
					'Execute'
				),
				array_merge(
					array(
						'SELECT COUNT(*) AS `count` FROM %s WHERE '.$where_clause,
						$this->get_table_name()
					),
					$args
				)
			) as $x) return $x->count!==0;
			
			throw new \Exception('COUNT query returned no rows');
		
		}
		
		
		private function is_auto_increment () {
		
			foreach ($this->events->Execute(
				'SELECT
					`AUTO_INCREMENT`
				FROM
					`information_schema`.`TABLES`
				WHERE
					`TABLE_SCHEMA`=DATABASE() AND
					`TABLE_NAME`=%s',
				$this->get_table_name_plain()
			) as $x) return !is_null($x->AUTO_INCREMENT);
			
			throw new \Exception(
				sprintf(
					'Could not find table %s in `information_schema`.`TABLES`',
					$this->get_table_name_plain()
				)
			);
		
		}
		
		
		private function get_primary_key () {
		
			foreach ($this->events->Execute(
				'SELECT
					COLUMN_NAME
				FROM
					`information_schema`.`COLUMNS`
				WHERE
					`TABLE_SCHEMA`=DATABASE() AND
					`TABLE_NAME`=%s AND
					`COLUMN_KEY`=\'PRI\'',
				$this->get_table_name_plain()
			) as $x) return $x->COLUMN_NAME;
			
			throw new \Exception(
				sprintf(
					'Could not find primary key for table %s in `information_schema`.`COLUMNS`',
					$this->get_table_name_plain()
				)
			);
		
		}
		
		
		private function get_key ($column) {
		
			foreach ($this->events->Execute(
				'SELECT MAX(%s) AS `value` FROM %s',
				new MySQL\Name($column),
				$this->get_table_name()
			) as $x) return $x->value+1;
			
			return 0;
		
		}
		
		
		/**
		 *	When implemented in a derived class, allows
		 *	the class to perform custom processing immediately
		 *	before a registration occurs.
		 *
		 *	During this function's execution, an exclusive
		 *	write lock will be held on the events database
		 *	table through the events connection.
		 *
		 *	If registration should be aborted, an appropriate
		 *	exception should be thrown.  This exception will be
		 *	allowed to pass through.
		 *
		 *	Any value this function returns will be ignored.
		 *
		 *	The default implementation does nothing, and is
		 *	provided so that derived classes do not necessarily
		 *	have to implement this method.
		 *
		 *	\param [in] $obj
		 *		The details of the registration which is being
		 *		performed.
		 */
		protected function PreRegisterHook (KeyValueWrapper $obj) {	}
		
		
		/**
		 *	Registers a participant.
		 *
		 *	\param [in] $obj
		 *		An object which may be iterated, the
		 *		keys giving the database column names,
		 *		the values giving the corresponding
		 *		database column values.
		 *	\param [in] $verify
		 *		An array giving the names of the columns
		 *		to check for duplicates in checking if
		 *		the participant being registered is already
		 *		registered.  Defaults to an array containing
		 *		\"firstname\" and \"lastname\".
		 *	\param [in] $case_insensitive
		 *		If \em true all SQL string comparisons shall
		 *		be done in a case insensitive manner.  Defaults
		 *		to \em true.
		 *
		 *	\return
		 *		The ID of the newly registered participant
		 *		if the underlying table uses automatically
		 *		generated IDs.
		 */
		public function Register ($obj, array $verify=array('firstname','lastname'), $case_insensitive=true) {
		
			//	Is the table auto increment?
			//
			//	If it's not we need to get the name
			//	of the primary key so we can generate
			//	an ID if necessary
			//
			//	Neither of these operations require
			//	table locking, so we do them before
			//	acquiring the lock
			if (!($ai=$this->is_auto_increment())) $key=$this->get_primary_key();
		
			//	Get the name of the table
			$table=$this->get_table_name();
			
			//	Lock table
			$lock=new MySQL\Lock($this->events,$table);
			
			//	Make sure that it's still possible/permissible
			//	to register
			if (!$this->check_count()) throw new CouldNotRegister(
				CouldNotRegister::FULL
			);
			
			//	Wrap whatever iterable object we were passed
			//	so we can access its keys at random
			$kv=new KeyValueWrapper($obj);
			
			//	Make sure that this participant has not already
			//	registered
			$arr=array();
			foreach ($verify as $x) {
			
				if (!isset($kv->$x)) throw new \Exception(
					'Field required to check for duplicate participants is missing'
				);
				
				$arr[$x]=$kv->$x;
			
			}
			if ($this->IsRegistered($arr,$case_insensitive)) throw new CouldNotRegister(
				CouldNotRegister::ALREADY_REGISTERED
			);
			
			//	Call the hook
			$this->PreRegisterHook($kv);
			
			//	If the table isn't auto increment, we need
			//	to find a unique ID for this row, unless
			//	the user provided one
			$insert_id=(
				$ai
					?	null
					:	(
							isset($kv->$key)
								?	$kv->$key
								:	($kv->$key=$this->get_key($key))
						)
			);
			
			//	Register
			$retr=$this->events->Insert($table,$kv);
			
			return is_null($insert_id) ? $retr : $insert_id;
		
		}
		
		
		/**
		 *	Determines whether early bird pricing is
		 *	currently in effect.
		 *
		 *	\return
		 *		\em true if early bird pricing is currently
		 *		in effect, \em false otherwise.
		 */
		public function IsEarlyBird () {
		
			//	If there's no early bird, it's obviously
			//	not early bird
			if (!isset($this->earlyBird)) return false;
			
			//	It's early bird if the current timestamp
			//	is smaller (i.e. before) the end of early
			//	bird timestamp
			return time()<$this->earlyBird->getTimestamp();
		
		}
		
		
		/** 
		 *	Gets the cost of this event.
		 *
		 *	\return
		 *		The cost of this event at this
		 *		time.
		 */
		public function GetCost () {
		
			$retr=Convert::ToFloat(
				$this->IsEarlyBird()
					?	$this->earlyCost
					:	$this->lateCost
			);
			
			return is_null($retr) ? 0.0 : round($retr,2);
		
		}
	
	
	}


?>