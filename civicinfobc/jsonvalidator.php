<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Validates objects acquired by deserializing
	 *	JSON.
	 */
	class JSONValidator {
	
	
		private $schema;
		private $detailed;
		private $stack;
		private $results;
		
		
		/**
		 *	Creates a new JSONValidator.
		 *
		 *	\param [in] $schema
		 *		The schema according to which to
		 *		validate JSON objects.
		 *	\param [in] $detailed
		 *		If \em true the Execute method
		 *		will return default output (an
		 *		array of JSONValidateResult objects)
		 *		by default, otherwise the
		 *		Execute method will simply
		 *		return \em true or \em false.
		 */
		public function __construct ($schema, $detailed=false) {
		
			$this->schema=$schema;
			$this->detailed=$detailed;
		
		}
		
		
		private function add ($expected, $got) {
		
			$this->results[]=new JSONValidateResult(
				$this->stack,
				$expected,
				$got
			);
		
		}
		
		
		private function stop () {
		
			return !($this->detailed || (count($this->results)===0));
		
		}
		
		
		private static $nullable='/^\\s*\\?|\\?\\s*$/u';
		
		
		private static function is ($a, $b) {
		
			return String::Equals($a,$b,true);
		
		}
		
		
		private static function is_nullable ($schema) {
		
			return Regex::IsMatch(self::$nullable,$schema);
		
		}
		
		
		private static function clean ($schema) {
		
			return String::Trim(
				Regex::Replace(
					self::$nullable,
					'',
					$schema
				)
			);
		
		}
		
		
		private static function get_type ($obj) {
		
			return (($retr=gettype($obj))==='double') ? 'float' : $retr;
		
		}
		
		
		private function validate_array ($data, $schema) {
		
			$match=Regex::Match(
				'/^(\\s*\\??\\s*array\\s*\\??)(.*)$/u',
				$schema
			);
			
			if (
				Regex::IsMatch(
					'/\\?/u',
					$match[1]
				) &&
				is_null($data)
			) return true;
			
			if (is_null($match=Regex::Match(
				'/\\s*of\\s+(.+)$/u',
				$match[2]
			))) throw new \InvalidArgumentException(
				sprintf(
					'"%s" is not a valid array specification',
					$schema
				)
			);
			
			$stack=$this->stack;
			foreach ($data as $key=>$value) {
			
				$this->stack=array_merge(
					$stack,
					array($key)
				);
				
				$this->validate_primitive(
					$value,
					$match[1]
				);
				
				if ($this->stop()) break;
			
			}
			$this->stack=$stack;
			
			return null;
		
		}
		
		
		private function validate_primitive_impl ($data, $schema) {
		
			if (Regex::IsMatch(
				'/^\\s*\\??\\s*array/ui',
				$schema
			)) return $this->validate_array($data,$schema);
		
			if (
				self::is_nullable($schema) &&
				is_null($data)
			) return true;
			
			$schema=self::clean($schema);
			
			if (self::is($schema,'string')) return is_string($data);
			
			if (self::is($schema,'number')) return is_float($data) || is_integer($data);
			
			if (self::is($schema,'float') || self::is($schema,'double')) return is_float($data);
			
			if (self::is($schema,'object')) return is_object($data);
			
			if (self::is($schema,'null')) return is_null($data);
			
			if (Regex::IsMatch(
				'/^int(?:eger)?$/ui',
				$schema
			)) return is_integer($data);
			
			if (Regex::IsMatch(
				'/^bool(?:ean)?$/ui',
				$schema
			)) return is_bool($data);
			
			throw new \InvalidArgumentException(
				sprintf(
					'"%s" is not a recognized JSON type',
					$schema
				)
			);
		
		}
		
		
		private function validate_primitive ($data, $schema) {
		
			if (is_null($result=$this->validate_primitive_impl($data,$schema))) return;
			
			if (!$result) $this->add(
				$schema,
				self::get_type($data)
			);
		
		}
		
		
		private static function has_key ($data, $key) {
		
			return is_array($data) ? array_key_exists($key,$data) : property_exists($data,$key);
		
		}
		
		
		private static function get_key ($data, $key) {
		
			return is_array($data) ? $data[$key] : $data->$key;
		
		}
		
		
		private function validate_aggregate ($data, $schema) {
		
			if (!(
				is_array($data) ||
				is_object($data)
			)) {
			
				$this->add(
					'aggregate',
					self::get_type($data)
				);
				
				return;
			
			}
			
			$stack=$this->stack;
			foreach ($schema as $key=>$value) {
			
				$this->stack=array_merge(
					$stack,
					array($key)
				);
				
				if (self::has_key($data,$key)) $this->validate(
					self::get_key($data,$key),
					$value
				);
				else $this->add(
					is_string($value) ? $value : 'aggregate',
					null
				);
				
				if ($this->stop()) break;
			
			}
			$this->stack=$stack;
		
		}
		
		
		private function validate ($data, $schema) {
		
			if (is_string($schema)) self::validate_primitive($data,$schema);
			else self::validate_aggregate($data,$schema);
		
		}
		
		
		/**
		 *	Validates a JSON object.
		 *
		 *	\param [in] $data
		 *		The JSON object.
		 *	\param [in] $detailed
		 *		If not \em null overrides the
		 *		\em detailed parameter given to
		 *		the constructor of this object for
		 *		this invocation only.  Defaults to
		 *		\em null.
		 */
		public function Execute ($data, $detailed=null) {
		
			$prev=$this->detailed;
			if (!is_null($detailed)) $this->detailed=$detailed;
			
			try {
		
				$this->stack=array();
				$this->results=array();
				
				$this->validate($data,$this->schema);
				
			} catch (\Exception $e) {
			
				$this->detailed=$prev;
				
				throw $e;
			
			}
			
			$this->detailed=$prev;
			
			return $this->detailed ? $this->results : (count($this->results)===0);
		
		}
	
	
	}


?>