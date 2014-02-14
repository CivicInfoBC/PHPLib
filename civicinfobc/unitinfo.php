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
		 *	An array containing the symbols for
		 *	this unit of measure.
		 */
		public $symbols;
		/**
		 *	An array containing the quantities this
		 *	unit of measure may be used to measure.
		 */
		public $quantities;
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
		 *	\param [in] $factor
		 *		The number of the base SI unit that
		 *		this unit represents.  Optional.  Defaults
		 *		to 1.0.
		 *	\param [in] $symbols_ignore_case
		 *		\em true if symbols for this unit should
		 *		be matched case insensitively, \em false
		 *		otherwise.  Defaults to \em false.
		 */
		public function __construct ($names, $symbols, $quantities, $factor=1.0, $symbols_ignore_case=false) {
		
			if (!is_array($names)) $names=array($names);
			$this->names=$names;
		
			if (!is_array($symbols)) $symbols=array($symbols);
			$this->symbols=$symbols;
			
			if (!is_array($quantities)) $quantities=array($quantities);
			$this->quantities=$quantities;
			
			$this->factor=$factor;
			
			$this->symbols_ignore_case=false;
		
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
				String::Trim($symbol),
				String::GetComparer($this->symbols_ignore_case)
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
				String::Trim($name),
				String::GetComparer(true)
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
		
			return ArrayUtil::In(
				$this->quantities,
				String::Trim($quantity),
				String::GetComparer(true)
			);
		
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
	
	
	}


?>