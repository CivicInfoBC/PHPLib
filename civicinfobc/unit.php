<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Represents a unit of measurement.
	 */
	class Unit {
	
	
		private static $data;
		
		
		/**
		 *	\cond
		 */
		
		
		//	Static constructor
		public static function Init () {
		
			self::$data=array(
				//	SI
				new UnitInfo(
					array(
						'metre',
						'meter'
					),
					array(
						'metres',
						'meters'
					),
					'm',
					'length'
				),
				new UnitInfo(
					'gram',
					'grams',
					'g',
					'mass'
				),
				new UnitInfo(
					array(
						'litre',
						'liter'
					),
					array(
						'litres',
						'liters'
					),
					'l',
					'volume',
					1.0,
					true
				),
				//	FPS
				new UnitInfo(
					'pound',
					'pounds',
					array(
						'lbs',
						'lb',
						'lbm'
					),
					'mass',
					453.59237,
					true
				),
				new UnitInfo(
					'foot',
					'feet',
					array(
						'ft',
						'′'
					),
					'length',
					0.3048,
					true
				),
				//	Other
				new UnitInfo(
					'inch',
					'inches',
					array(
						'in',
						'″'
					),
					'length',
					0.0254,
					true
				),
				new UnitInfo(
					'mile',
					'miles',
					array(),
					'length',
					1609.344
				)
			);
		
		}
		
		
		/**
		 *	\endcond
		 */
		 
		
		private static function not_found ($str, \Exception $prev=null) {
		
			throw new \InvalidArgumentException(
				sprintf(
					'No unit "%s" could be found',
					$str
				),
				$prev
			);
		
		}
		
		
		public static function Get ($str, $throw=true) {
		
			foreach (self::$data as $info) {
			
				if ($info->IsRepresented($str)) return $info;
			
			}
			
			if ($throw) self::not_found($str);
			
			return null;
		
		}
	
	
		/**
		 *	An SIPrefix object which indicates which
		 *	prefix this unit has, if any.
		 */
		public $prefix;
		/**
		 *	A UnitInfo object which contains all information
		 *	about the base unit of this unit.
		 */
		public $info;
		
		
		/** 
		 *	Obtains a Unit object which corresponds to the
		 *	unit contained in a certain string.
		 *
		 *	\param [in] $str
		 *		The string.
		 */
		public function __construct ($str) {
		
			//	Is the passed in string directly
			//	a unit?
			$this->info=self::Get($str,false);
			
			if (is_null($this->info)) {
			
				//	NO
				
				//	Get the prefix
				$this->prefix=SIPrefix::Get($str);
				
				//	Attempt to find a unit that
				//	corresponds to the new string
				$this->info=self::Get($str);
			
			}
			
			if (is_null($this->prefix)) $this->prefix=new SIPrefix();
		
		}
		
		
		/**
		 *	Obtains a string representation of this unit.
		 *
		 *	\return
		 *		A string representation of this unit.
		 */
		public function __toString () {
		
			return ((string)$this->prefix).$this->info->names[0];
		
		}
		
		
		/**
		 *	Gets the total factor for this unit, including
		 *	the prefix.
		 *
		 *	This factor indicates how many of the SI base
		 *	unit for the quantity this unit measures each
		 *	of this unit represents.
		 *
		 *	\return
		 *		The factor.
		 */
		public function GetFactor () {
		
			return $this->prefix->GetMultiplier()*$this->info->factor;
		
		}
	
	
	}
	
	
	Unit::Init();


?>