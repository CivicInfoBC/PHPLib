<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Wraps an object or array which maps keys
	 *	to values, whether it does so through object
	 *	property syntax, or through array syntax.
	 */
	class KeyValueWrapper implements \IteratorAggregate {
	
	
		private $obj;
		
		
		/**
		 *	Creates a new KeyValueWrapper.
		 *
		 *	\param [in] $obj
		 *		The object or array to wrap.
		 */
		public function __construct ($obj) {
		
			$this->obj=$obj;
		
		}
		
		
		private function is_array_like () {
		
			return is_array($this->obj) || ($this->obj instanceof \ArrayAccess);
		
		}
		
		
		private function get ($key) {
		
			if (
				isset($this->obj->$key) &&
				!is_null($this->obj->$key)
			) return $this->obj->$key;
			
			if (
				$this->is_array_like() &&
				isset($this->obj[$key])
			) return $this->obj[$key];
			
			return null;
		
		}
		
		
		/**
		 *	Checks whether a certain key has an associated
		 *	value.
		 *
		 *	\param [in] $key
		 *		The key to check.
		 *
		 *	\return
		 *		\em true if \em key has an associated value,
		 *		\em false otherwise.
		 */
		public function __isset ($key) {
		
			return !is_null($this->get($key));
		
		}
		
		
		/**
		 *	Retrieves the value associated with a certain key.
		 *
		 *	\param [in] $key
		 *		The key whose value shall be retrieved.
		 *
		 *	\return
		 *		The value associated with \em key if \em key has
		 *		an associated value, \em null otherwise.
		 */
		public function __get ($key) {
		
			return $this->get($key);
		
		}
		
		
		private function unset_impl ($key) {
		
			unset($this->obj->$key);
			if ($this->is_array_like()) unset($this->obj[$key]);
		
		}
		
		
		/**
		 *	Unsets the value associated with a certain key.
		 *
		 *	\param [in] $key
		 *		The key whose value shall be unset.
		 */
		public function __unset ($key) {
		
			$this->unset_impl($key);
		
		}
		
		
		/**
		 *	Sets the value associated with a certain key.
		 *
		 *	\param [in] $key
		 *		The key whose value shall be set.
		 *	\param [in] $value
		 *		The value to set.
		 */
		public function __set ($key, $value) {
		
			$this->unset_impl($key);
			if ($this->is_array_like()) $this->obj[$key]=$value;
			else $this->obj->$key=$value;
		
		}
		
		
		public function getIterator () {
		
			if ($this->obj instanceof \Iterator) return $this->obj;
			if ($this->obj instanceof \IteratorAggregate) return $this->obj->getIterator();
		
			return new \ArrayIterator($this->obj);
		
		}
	
	
	}


?>