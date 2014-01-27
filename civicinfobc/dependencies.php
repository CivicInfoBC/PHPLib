<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	A container for dependencies.
	 *
	 *	The method for obtaining dependencies is
	 *	specified, and those dependencies are
	 *	lazily obtained.
	 */
	class Dependencies {
	
	
		private $resolved;
		private $available;
		
		
		/**
		 *	Creates a new dependency container.
		 *
		 *	\param [in] $arr
		 *		An associative array which maps the
		 *		names of dependencies to callable
		 *		objects or values which may be invoked
		 *		to obtain the actual dependency.
		 */
		public function __construct ($arr) {
		
			$this->available=$arr;
		
		}
		
		
		private function retrieve ($key) {
		
			if (isset($this->resolved[$key])) return $this->resolved[$key];
			
			if (isset($this->available[$key])) {
			
				$callback=$this->available[$key];
				$this->resolved[$key]=$callback();
				
				return $this->resolved[$key];
			
			}
			
			return null;
		
		}
		
		
		/**
		 *	Retrieves a dependency.  If it cannot be
		 *	retrieved because it does not exist some
		 *	default value is retrieved instead.
		 *
		 *	\param [in] $key
		 *		The key associated with the dependency
		 *		to retrieve.
		 *	\param [in] $default
		 *		The default value to be returned if the
		 *		dependency container has no record of
		 *		a dependency with key \em key.  Defaults
		 *		to \em null.
		 *
		 *	\return
		 *		The requested dependency, or \em default if
		 *		the requested dependency could not be
		 *		found.
		 */
		public function Get ($key, $default=null) {
		
			$retr=$this->retrieve($key);
			
			if (is_null($retr)) return $default;
			
			return $retr;
		
		}
		
		
		/**
		 *	Determines if there is a dependency associated
		 *	with a particular key.
		 *
		 *	\param [in] $key
		 *		The key to check.
		 *
		 *	\return
		 *		\em true if the dependency container has a
		 *		dependency associated with \em key, \em false
		 *		otherwise.
		 */
		public function __isset ($key) {
		
			return isset($this->available[$key]);
		
		}
		
		
		/**
		 *	Retrieves a dependency.  If it cannot be retrieved
		 *	because it does not exist an exception will be
		 *	thrown.
		 *
		 *	\param [in] $key
		 *		The key associated with the dependency to
		 *		retrieve.
		 *
		 *	\return
		 *		The requested dependency.
		 */
		public function __get ($key) {
		
			$retr=$this->retrieve($key);
			
			if (is_null($retr)) throw new \Exception(
				sprintf(
					'Request for unknown dependency "%s"',
					$key
				)
			);
			
			return $retr;
		
		}
	
	
	}


?>