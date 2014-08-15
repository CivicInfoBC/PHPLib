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
		 *	Determines if the appropriate backdoor is set
		 *	in the query string.
		 *
		 *	\param [in] $backdoor
		 *		A backdoor to check in addition to the backdoor
		 *		from the database.
		 *
		 *	\return
		 *		\em true if the appropriate backdoor is set,
		 *		\em false otherwise.
		 */
		public function IsBackdoor ($backdoor=null) {
		
			if (!isset(Request::$get->backdoor)) return false;
			
			return String::Equals(
				$backdoor,
				Request::$get->backdoor
			) || String::Equals(
				$this->billUsername,
				Request::$get->backdoor
			);
		
		}
		
		
		/**
		 *	Determines whether a registration is
		 *	open or not.
		 *
		 *	\param [in] $backdoor
		 *		A backdoor to check in addition to the backdoor
		 *		from the database.
		 *
		 *	\return
		 *		\em true if this registration is open,
		 *		\em false otherwise.
		 */
		public function IsOpen ($backdoor=null) {
		
			//	Determine if the registration is open
			//	because of the backdoor
			if ($this->IsBackdoor($backdoor)) return true;
			
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
		 *	\param [in] $options
		 *		The options associated with this registration.
		 */
		protected function PreRegisterHook (KeyValueWrapper $obj, EventRegisterOptions $options) {	}
		
		
		/**
		 *	Adds common fields to an object if they are not
		 *	already present.
		 *
		 *	\param [in] $obj
		 *		The object to which to add the common fields.
		 */
		public function AddCommon ($obj) {
		
			$kv=new KeyValueWrapper($obj);
			
			if (!isset($kv->datepaid)) $kv->paid='NO';
			
			if (!isset($kv->datereg)) $kv->datereg=new MySQL\Literal('NOW()');
		
		}
		
		
		/**
		 *	Registers a participant.
		 *
		 *	\param [in] $obj
		 *		An object which may be iterated, the
		 *		keys giving the database column names,
		 *		the values giving the corresponding
		 *		database column values.
		 *	\param [in] $options
		 *		An EventRegisterOptions giving the options
		 *		to use for this registration.  Defaults to
		 *		\em null.  If \em null a default constructed
		 *		EventRegisterOptions object shall be used.
		 *
		 *	\return
		 *		The ID of the newly registered participant.
		 */
		public function Register ($obj, EventRegisterOptions $options=null) {
		
			if (is_null($options)) $options=new EventRegisterOptions();
		
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
			if (!($options->exceed_capacity || $this->check_count())) throw new CouldNotRegister(
				CouldNotRegister::FULL
			);
			
			//	Wrap whatever iterable object we were passed
			//	so we can access its keys at random
			$kv=new KeyValueWrapper($obj);
			
			//	Make sure that this participant has not already
			//	registered
			$arr=array();
			foreach ($options->verify as $x) {
			
				if (!isset($kv->$x)) throw new \Exception(
					'Field required to check for duplicate participants is missing'
				);
				
				$arr[$x]=$kv->$x;
			
			}
			if ($this->IsRegistered($arr,$options->case_insensitive)) throw new CouldNotRegister(
				CouldNotRegister::ALREADY_REGISTERED
			);
			
			//	Call the hook
			$this->PreRegisterHook($kv,$options);
			
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
	
	
		/**
		 *	Used for formatting registration details.
		 *
		 *	Defaults to an empty array.
		 */
		protected static $format_map=array();
	
	
		/**
		 *	Gets a format map for use by the Format
		 *	method.
		 *
		 *	A map is an array which specifies how
		 *	registration details should be formatted.
		 *
		 *	Integer keys give headings, string keys are
		 *	taken to be a key in the registration details
		 *	object.
		 *
		 *	If a specified key in the registration details
		 *	object is set, a formatted entry will be emitted
		 *	with the value associated with that key in this
		 *	map is tha key, and the value provided by the
		 *	registration details object as the value.
		 *
		 *	Entries will be processed in order.
		 *
		 *	A default implementation is provided which returns
		 *	the static member \em format_map (late bound) for
		 *	convenience.
		 *
		 *	\param [in] $obj
		 *		The details of the registration which is
		 *		being performed.
		 *
		 *	\return
		 *		The map.
		 */
		protected function GetFormatMap (KeyValueWrapper $obj) {
		
			return static::$format_map;
		
		}
	
	
		/**
		 *	Performs custom processing on a value to be
		 *	formatted.
		 *
		 *	A default implementation is provided which
		 *	reformats all floating-point values as dollars,
		 *	and all booleans as \"Yes\" or \"No\".
		 *
		 *	\param [in] $key
		 *		The key being processed.
		 *	\param [in] $label
		 *		The label from the format map which will
		 *		be applied to this value.
		 *	\param [in] $obj
		 *		All key value pairs which make up the
		 *		registration details.
		 *
		 *	\return
		 *		\em false to skip this key.  \em null to
		 *		process as per the default.  A string to
		 *		substitute that value.
		 */
		protected function FormatFilter ($key, $label, KeyValueWrapper $obj) {
		
			if (is_float($obj->$key)) return sprintf(
				'$%.2f',
				round($obj->$key,2)
			);
			
			if (is_bool($obj->$key)) return $obj->$key ? 'Yes' : 'No';
		
			return null;
		
		}
	
	
		/**
		 *	Formats registration details according
		 *	to a map provided by the derived class
		 *	and accessed using late static binding.
		 *
		 *	\param [in] $obj
		 *		An object which may be iterated, the
		 *		keys being keys in the map, the values
		 *		being the desired values.
		 *
		 *	\return
		 *		An array of both strings and KeyValuePair
		 *		objects, where strings are headings, and
		 *		KeyValuePair objects are formatted details.
		 */
		public function Format ($obj) {
		
			$kv=new KeyValueWrapper($obj);
			
			$retr=array();
			$found=null;
			foreach ($this->GetFormatMap($kv) as $key=>$value) {
			
				if (is_integer($key)) {
				
					$found=$value;
					
				} else if (isset($kv->$key)) {
				
					$result=$this->FormatFilter(
						$key,
						$value,
						$kv
					);
					
					if ($result===false) continue;
				
					if (!is_null($found)) {
					
						$retr[]=$found;
						$found=null;
					
					}
					
					$retr[]=new KeyValuePair(
						$value,
						is_null($result) ? $kv->$key : $result
					);
				
				}
			
			}
			
			return $retr;
		
		}
	
	
		protected static $payment_form_map=array(
			'firstname' => 'first_name',
			'lastname' => 'last_name',
			'representing' => 'company',
			'email',
			'total' => 'amount',
		);
	
	
		public function GetPaymentForm (EXact\HostedCheckout $hco, $id, $obj) {
		
			//	Create the form
			$form=new EXact\SingleItemForm($hco);
		
			//	Wrap the object/array/etc.
			$kv=new KeyValueWrapper($obj);
			
			//	Get values
			foreach (static::$payment_form_map as $o_key=>$e_key) {
			
				if (is_integer($o_key)) $o_key=$e_key;
				
				$form->$e_key=$kv->$o_key;
			
			}
			
			//	Add the database table, customer ID,
			//	and type
			$form->cust_id=$id;
			$form->description=$this->eventname;
			$form->type='Registration Fee';
			//	I don't know why this field is used
			//	to hold the literal database name,
			//	but it is...
			$form->po_num=$this->get_table_name_plain();
			
			return $form;
		
		}
		
		
		/**
		 *	Determines the number of people registered in a certain
		 *	session.
		 *
		 *	\param [in] $column
		 *		The name of the database column to check.
		 *	\param [in] $value
		 *		The name of the value which indicates the desired
		 *		session.
		 *
		 *	\return
		 *		The number of people in the given session.
		 */
		protected function CheckSession ($column, $value) {
		
			$column=new MySQL\Name($column);
			$table=$this->get_table_name();
			$str='SELECT COUNT(*) as `count` FROM %s WHERE %s';
			$results=is_null($value) ? $this->events->Execute(
				$str.' IS NULL',
				$table,
				$column
			) : $this->events->Execute(
				$str.'=%s',
				$table,
				$column,
				$value
			);
		
			foreach ($results as $row) return $row->count;
			
			return 0;
		
		}
		
		
		private static function email_to (array $args) {
		
			$retr=array();
			foreach ($args as $arg) if (is_array($arg)) $retr=array_merge(
				$retr,
				self::email_to($arg)
			);
			else $retr[]=$arg;
			
			return $retr;
		
		}
		
		
		/**
		 *	Gets an e-mail object which can be used to send
		 *	registration confirmation e-mails.
		 *
		 *	The e-mail will be sent to all parameters passed.
		 *	Arrays will be flattened.
		 */
		protected function GetEMail () {
		
			$retr=new \CivicInfoBC\EMail();
			$retr->is_html=true;
			$retr->subject=sprintf(
				'REGISTRATION: %s - %s, %s',
				$this->organizer,
				$this->eventname,
				$this->FormatDate()
			);
			$retr->to=self::email_to(func_get_args());
			
			return $retr;
		
		}
		
		
		/**
		 *	Formats the date(s) on which the event occurs.
		 *
		 *	\return
		 *		A formatted string.
		 */
		public function FormatDate () {
		
			$range=new \CivicInfoBC\DateTimeRange(
				$this->startdate,
				$this->enddate
			);
			
			return $range->Format(array(
				'Y' => '^F ^j^S, ^Y - $F $j$S, $Y',
				'n' => '^F ^j^S - $F $j$S, Y',
				'j' => 'F ^j^S - $j$S, Y',
				'' => 'F jS, Y'
			));
		
		}
	
	
	}


?>