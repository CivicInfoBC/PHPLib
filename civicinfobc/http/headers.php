<?php


	namespace CivicInfoBC\HTTP;
	
	
	/**
	 *	Provides a container for HTTP headers.
	 */
	class Headers implements \Countable, \IteratorAggregate {
	
	
		private $arr=array();
		
		
		/**
		 *	Creates a Headers object.
		 *
		 *	\param [in] $arr
		 *		An object which may be iterator to obtain the headers.
		 *		If \em null the object will be created empty.  Defaults
		 *		to \em null.
		 */
		public function __construct ($obj=null) {
		
			if (is_null($obj)) return;
		
			foreach ($obj as $key=>$value) $this->Add($key,$value,false);
		
		}
		
		
		/**
		 *	Gets a Headers object containing the headers from the
		 *	current request.
		 *
		 *	\return
		 *		A Headers object.
		 */
		public static function FromRequest () {
		
			return new self(\CivicInfoBC\Request::GetHeaders());
		
		}
		
		
		private static function to_key ($key) {
		
			return \CivicInfoBC\String::ToLower($key);
		
		}
		
		
		/**
		 *	Determines the number of values.
		 *
		 *	\return
		 *		The number of values.
		 */
		public function count () {
		
			$retr=0;
			foreach ($this->arr as $key=>$value) $retr+=count($value);
			
			return $retr;
		
		}
		
		
		/**
		 *	Retrieves a header.
		 *
		 *	\param [in] $key
		 *		The key of the header to retrieve.  Is matched
		 *		case insensitively.
		 *
		 *	\return
		 *		An array of all values associated with \em key.
		 */
		public function __get ($key) {
		
			$key=self::to_key($key);
			
			return isset($this->arr[$key]) ? $this->arr[$key] : array();
		
		}
		
		
		/**
		 *	Determines whether there are values associated with
		 *	a certain key.
		 *
		 *	\param [in] $key
		 *		The key.  Is matched case insensitively.
		 *
		 *	\return
		 *		\em true if there are values associated with \em key,
		 *		\em false otherwise.
		 */
		public function __isset ($key) {
		
			$key=self::to_key($key);
		
			return isset($this->arr[$key]) ? (count($this->arr[$key])!==0) : false;
		
		}
		
		
		/**
		 *	Adds a header.
		 *
		 *	\param [in] $key
		 *		The name of the header to add.
		 *	\param [in] $value
		 *		The value to associate with \em key.
		 *	\param [in] $replace
		 *		If \em true \em value will replace whatever is
		 *		currently associated with \em key.  Otherwise
		 *		\em value will be added to the values associated
		 *		with \em key.  Defaults to \em true.
		 */
		public function Add ($key, $value, $replace=true) {
		
			$key=self::to_key($key);
			$value=\CivicInfoBC\ArrayUtil::Coalesce($value);
			
			if (!isset($this->arr[$key]) || $replace) {
			
				$this->arr[$key]=$value;
				
				return;
			
			}
			
			$this->arr[$key]=array_merge($this->arr[$key],$value);
		
		}
		
		
		/**
		 *	Removes all values associated with a header.
		 *
		 *	\param [in] $key
		 *		The header.
		 */
		public function __unset ($key) {
		
			unset($this->arr[self::to_key($key)]);
		
		}
		
		
		/**
		 *	Sets the value associated with a header as
		 *	though calling the Add method with \em replace
		 *	set to \em true.
		 *
		 *	\param [in] $key
		 *		The header.
		 *	\param [in] $value
		 *		The value.
		 */
		public function __set ($key, $value) {
		
			$this->Add($key,$value);
		
		}
		
		
		/**
		 *	Attempts to retrieve a value associated with a
		 *	header, or some alternative value if there are
		 *	no values associated with the given header.
		 *
		 *	\param [in] $key
		 *		The header.
		 *	\param [in] $default
		 *		The default.  Defaults to \em null.
		 *
		 *	\return
		 *		A value associated with \em key, if there are
		 *		any such values.  Otherwise \em default.
		 */
		public function Get ($key, $default=null) {
		
			$arr=$this->__get($key);
			return (count($arr)===0) ? $default : $arr[0];
		
		}
		
		
		public function getIterator () {
		
			return new \ArrayIterator($this->arr);
		
		}
	
	
	}


?>