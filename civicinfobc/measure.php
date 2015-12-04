<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Represents a measurement taken with
	 *	some unit of measure.
	 */
	class Measure {
	
	
		public $quantity;
		public $unit;
		
		
		private static function extract_unit (&$str) {
		
			$pattern='/\\s*(\\D+)$/u';
		
			$match=Regex::Match(
				$pattern,
				$str
			);
			
			if (is_null($match)) throw new \InvalidArgumentException(
				sprintf(
					'Cannot extract a unit of measure from "%s"',
					$str
				)
			);
			
			$str=Regex::Replace(
				$pattern,
				'',
				$str
			);
			
			return $match[1];
		
		}
		
		
		private function construct_1 ($str) {
		
			$this->unit=new Unit(self::extract_unit($str));
			$this->quantity=Convert::ToFloatOrThrow($str);
		
		}
		
		
		private static function get_unit ($unit) {
		
			return ($unit instanceof Unit) ? $unit : new Unit($unit);
		
		}
		
		
		private function construct_2 ($quantity, $unit) {
		
			$this->quantity=Convert::ToFloatOrThrow($quantity);
			$this->unit=self::get_unit($unit);
		
		}
		
		
		/**
		 *	Creates a new measurement.
		 *
		 *	This constructor may be called one of
		 *	two ways:
		 *
		 *	1.	With one argument, a string containing
		 *		both the quantity of units, and the
		 *		units of measurement.
		 *
		 *	2.	With two arguments, the first of
		 *		which is the quantity of units,
		 *		and the second of which is either
		 *		a string representing the units,
		 *		or a Unit object detailing the
		 *		units.
		 *
		 *	\param [in] $a
		 *		The first argument.
		 *	\param [in] $b
		 *		The optional second argument.
		 */
		public function __construct ($a, $b=null) {
		
			if (is_null($b)) $this->construct_1($a);
			else $this->construct_2($a,$b);
		
		}
		
		
		/**
		 *	Obtains a string representation of this
		 *	measurement.
		 *
		 *	\param [in] $use_symbol
		 *		\em true if the output should use
		 *		symbols for the units, \em false
		 *		otherwise.  Defaults to \em false.
		 *
		 *	\return
		 *		A string representation of this
		 *		measurement.
		 */		
		public function ToString ($use_symbol=false) {
		
			$retr=$this->quantity;
			if (
				$use_symbol &&
				!is_null($symbol=$this->unit->info->GetSymbol(false))
			) {
			
				$retr.=$this->unit->prefix->GetSymbol();
				$retr.=$symbol;
			
			} else {
			
				$retr.=' ';
				$retr.=$this->unit->prefix;
				$retr.=$this->unit->info->GetName(
					$this->quantity!==1.0
				);
			
			}
			
			return $retr;
		
		}
		
		
		/**
		 *	Obtains a string representation of this
		 *	measurement.
		 *
		 *	\return
		 *		A string representation of this
		 *		measurement.
		 */
		public function __toString () {
		
			return $this->ToString();
		
		}
		
		
		private static function get_factor (Unit $from, Unit $to) {
		
			return floatval($from->GetFactor())/floatval($to->GetFactor());
		
		}
		
		
		/**
		 *	Converts a numerical quantity from one
		 *	unit to another.
		 *
		 *	\param [in] $quantity
		 *		The numerical quantity which is in
		 *		units given by \em from.
		 *	\param [in] $from
		 *		The units to convert from.
		 *	\param [in] $to
		 *		The units to convert to.
		 *
		 *	\return
		 *		The converted numerical quantity.
		 */
		public static function Convert ($quantity, $from, $to) {
		
			$from=self::get_unit($from);
			$to=self::get_unit($to);
		
			if (!$from->info->DoesMeasure($to->info->quantity)) throw new \InvalidArgumentException(
				sprintf(
					'Expected a measure of %s but a measure of %s was given',
					StringUtil::ToLower($from->info->quantity),
					StringUtil::ToLower($to->info->quantity)
				)
			);
		
			return $quantity*self::get_factor($from,$to);
		
		}
		
		
		/**
		 *	Converts this measurement to some other
		 *	unit of measure.
		 *
		 *	If the provided unit of measure does
		 *	not measure the same quantity as the
		 *	units used to take this measurement,
		 *	an exception is thrown.
		 *
		 *	\param [in] $unit
		 *		The units this measurement shall
		 *		be converted to.
		 *
		 *	\return
		 *		A Measure object representing the
		 *		converted measurement.
		 */
		public function To ($unit) {
		
			$unit=self::get_unit($unit);
		
			return new self(
				self::Convert(
					$this->quantity,
					$this->unit,
					$unit
				),
				$unit
			);
		
		}
		
		
		/**
		 *	Compares this measure to another measure.
		 *
		 *	\param [in] $other
		 *		The measure with which to compare this
		 *		measure.
		 *
		 *	\return
		 *		0 if both measures represent the same
		 *		measurement.  A value below 0 if this
		 *		measure represents a smaller measurement
		 *		than \em other.  A positive value
		 *		otherwise.
		 */
		public function Compare (Measure $other) {
		
			$other=$other->To($this->unit);
			
			if ($other->quantity===$this->quantity) return 0;
			
			if ($this->quantity<$other->quantity) return -1;
			
			return 1;
		
		}
		
		
		/**
		 *	Adds this measure to another measure.
		 *
		 *	\param [in] $other
		 *		The measure to add to this measure.
		 *
		 *	\return
		 *		A new measure which is the result of
		 *		adding the two measures.  The new
		 *		measure is in the units of this
		 *		measure.
		 */
		public function Add (Measure $other) {
		
			$other=$other->To($this->unit);
			
			$retr=clone $this;
			
			$retr->quantity+=$other->quantity;
			
			return $retr;
		
		}
		
		
		/**
		 *	Multiplies this measure by some amount.
		 *
		 *	\param [in] $factor
		 *		The factor by which to multiply this
		 *		measure.
		 *
		 *	\return
		 *		A new measure which is the result of
		 *		multiplying this measure by \em factor.
		 */
		public function Multiply ($factor) {
		
			$retr=clone $this;
			
			$retr->quantity*=$factor;
			
			return $retr;
		
		}
	
	
	}


?>