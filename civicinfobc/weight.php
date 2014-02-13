<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Encapsulates a weight.
	 */
	class Weight extends Measure {
	
	
		const KILOGRAM=0;
		const GRAM=1;
		const MILLIGRAM=2;
		const TONNE=3;
		const POUND=4;
		const SLUG=5;
		const TON=6;
		const LONG_TON=6;
		const SHORT_TON=7;
		const STONE=8;
		
		
		//	All relative to the kilogram
		protected static $conversion_table=array(
			self::KILOGRAM => 1.0,
			self::GRAM => 0.001,
			self::MILLIGRAM => 0.000001,
			self::TONNE => 1000.0,
			self::POUND => 2.2046226218487758072297380134503,
			self::SLUG => 14.593903,
			self::TON => 1016.047,
			self::SHORT_TON => 907.1847,
			self::STONE => 6.35029
		);
	
	
	}


?>