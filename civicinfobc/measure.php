<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Provides abstracted utilities for converting
	 *	between units of measure.
	 *
	 *	Relies on being extended for a conversion table
	 *	to be provided.
	 */
	class Measure {
	
	
		/**
		 *	The number of a certain unit that this
		 *	instance represents.
		 */
		protected $quantity;
		/**
		 *	A code which can be used to look up the
		 *	units this measure is in.
		 */
		protected $unit;
	
	
		/**
		 *	Derived classes should supply their own
		 *	\em conversion table, which maps values
		 *	which represent a certain unit to a
		 *	conversion factor for that unit.  Late
		 *	static binding will be used and that
		 *	table will be used instead of this
		 *	table.
		 */
		protected static $conversion_table=array();
		
		
		/**
		 *	Initializes this base class.
		 *
		 *	\param [in] $quantity
		 *		The size of the measure to represent,
		 *		in units given by \em unit.
		 *	\param [in] $unit
		 *		A code which can be used to look up
		 *		the units in \em conversion_table.
		 */
		public function __construct ($quantity, $unit) {
		
			$this->quantity=Convert::ToFloat($quantity);
			$this->unit=$unit;
		
		}
		
		
		private static function get ($unit) {
		
			if (!isset(static::$conversion_table[$unit])) throw new \InvalidArgumentException(
				'No conversion factor specified for the provided unit'
			);
			
			return floatval(static::$conversion_table[$unit]);
		
		}
		
		
		private static function get_factor ($from, $to) {
		
			return self::get($to)/self::get($from);
		
		}
		
		
		/**
		 *	Converts a quantity of one unit to an
		 *	equivalent quantity represented as another
		 *	unit.
		 *
		 *	\param [in] $from
		 *		The quantity.
		 *	\param [in] $from_unit
		 *		The units of \em from.
		 *	\param [in] $to_unit
		 *		The desired units.
		 *
		 *	The quantity of \em from_unit given by \em from
		 *	converted to \em to_unit.
		 */
		public static function Convert ($from, $from_unit, $to_unit) {
		
			return $from*self::get_factor($from_unit,$to_unit);
		
		}
		
		
		/**
		 *	Converts the quantity encapsulated by this
		 *	object to another unit.
		 *
		 *	\param [in] $unit
		 *		The units to convert to.
		 *
		 *	\return
		 *		The measure encapsulated in this object,
		 *		converted to the units given by \em unit.
		 */
		public function To ($unit) {
		
			return self::Convert(
				$this->quantity,
				$this->unit,
				$unit
			);
		
		}
	
	
	}


?>