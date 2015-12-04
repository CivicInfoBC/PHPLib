<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Encapsulates information about a unit
	 *	of measure.
	 */
	class UnitInfo {
	
	
		/**
		 *	An array containing the names of this
		 *	unit of measure.
		 */
		public $names;
		/**
		 *	An array containing the plural forms of
		 *	the names of this unit of measure.
		 */
		public $plural;
		/**
		 *	An array containing the symbols for
		 *	this unit of measure.
		 */
		public $symbols;
		/**
		 *	An array containing the quantities this
		 *	unit of measure may be used to measure.
		 */
		public $quantity;
		/**
		 *	A factor, encapsulating how many of the
		 *	base SI unit this unit represents.
		 */
		public $factor;
		/**
		 *	A boolean value indicating whether or not
		 *	symbols for this unit should be matched
		 *	case insensitively.
		 */
		public $symbols_ignore_case;
		
		
		private static function coalesce ($arr, $empty=true) {
		
			if (is_array($arr)) {
			
				if (!$empty && (count($arr)===0)) throw new \InvalidArgumentException(
					'Unexpected empty array'
				);
				
				return $arr;
			
			}
			
			return array($arr);
		
		}
		
		
		/**
		 *	Creates a new UnitInfo object.
		 *
		 *	\param [in] $names
		 *		The name of this unit of measure,
		 *		or an array containing all such
		 *		names.
		 *	\param [in] $symbols
		 *		The symbol for this unit of measure,
		 *		or an array containing all such
		 *		symbols.
		 *	\param [in] $quantities
		 *		The quantity this unit measures, or
		 *		an array containing all such quantities.
		 *	\param [in] $factors
		 *		The number of the base SI unit that
		 *		this unit represents.  Optional.  Defaults
		 *		to 1.0.
		 *	\param [in] $symbols_ignore_case
		 *		\em true if symbols for this unit should
		 *		be matched case insensitively, \em false
		 *		otherwise.  Defaults to \em false.
		 */
		public function __construct ($names, $plural, $symbols, $quantity, $factor=1.0, $symbols_ignore_case=false) {
		
			$this->names=self::coalesce($names,false);
			$this->plural=self::coalesce($plural);
			$this->symbols=self::coalesce($symbols);
			$this->quantity=$quantity;
			$this->factor=$factor;
			$this->symbols_ignore_case=$symbols_ignore_case;
		
		}
		
		
		/**
		 *	Determines whether this unit of measure
		 *	is represented by a certain symbol.
		 *
		 *	\param [in] $symbol
		 *		The symbol.
		 *
		 *	\return
		 *		\em true if this unit of measure is
		 *		represented by \em symbol, \em false
		 *		otherwise.
		 */
		public function HasSymbol ($symbol) {
		
			return ArrayUtil::In(
				$this->symbols,
				StringUtil::Trim($symbol),
				StringUtil::GetComparer($this->symbols_ignore_case)
			);
		
		}
		
		
		/**
		 *	Determines whether this unit of measure has
		 *	a certain name.
		 *
		 *	\param [in] $name
		 *		The name.
		 *
		 *	\return
		 *		\em true if this unit of measure has
		 *		\em name as a name, \em false otherwise.
		 */
		public function IsNamed ($name) {
		
			return ArrayUtil::In(
				$this->names,
				$name=StringUtil::Trim($name),
				$comparer=StringUtil::GetComparer(true)
			) || ArrayUtil::In(
				$this->plural,
				$name,
				$comparer
			);
		
		}
		
		
		/**
		 *	Determines whether this unit of measure
		 *	has a certain symbol or name.
		 *
		 *	\param [in] $str
		 *		The symbol or name.
		 *
		 *	\return
		 *		\em true if this unit of measure has
		 *		\em str as a name or symbol, \em false
		 *		otherwise.
		 */
		public function IsRepresented ($str) {
		
			return $this->HasSymbol($str) || $this->IsNamed($str);
		
		}
		
		
		/**
		 *	Determines whether this unit measures
		 *	a certain quantity.
		 *
		 *	\param [in] $quantity
		 *		The quantity.
		 *
		 *	\return
		 *		\em true if this unit measures
		 *		\em quantity, \em false otherwise.
		 */
		public function DoesMeasure ($quantity) {
		
			return StringUtil::Equals($this->quantity,$quantity,true);
		
		}
		
		
		/**
		 *	Determines whether this unit is part of
		 *	SI.
		 *
		 *	\return
		 *		\em true if this unit is part of SI,
		 *		\em false otherwise.
		 */
		public function IsSI () {
		
			return $this->factor===1.0;
		
		}
		
		
		/**
		 *	Gets a name for this unit.
		 *
		 *	\param [in] $plural
		 *		Optional.  If \em true the
		 *		plural form of this unit's name
		 *		will be retrieved.  Defauls
		 *		to \em false.
		 *
		 *	\return
		 *		A name for this unit.
		 */
		public function GetName ($plural=false) {
		
			if (
				$plural &&
				(count($this->plural)!==0)
			) return $this->plural[0];
			
			return $this->names[0];
		
		}
		
		
		/**
		 *	Gets a symbol for this unit.
		 *
		 *	\param [in] $throw
		 *		If \em true this method will
		 *		throw if this unit has no
		 *		symbols, otherwise \em null
		 *		will simply be returned if
		 *		there are no symbols.  Defaults
		 *		to \em true.
		 *
		 *	\return
		 *		A symbol for this unit.
		 */
		public function GetSymbol ($throw=true) {
		
			if (count($this->symbols)===0) {
			
				if ($throw) throw new NotFoundException(
					sprintf(
						'Unit "%s" has no associated symbols',
						$this->GetName()
					)
				);
				
				return null;
			
			}
		
			return $this->symbols[0];
		
		}
	
	
	}


?>