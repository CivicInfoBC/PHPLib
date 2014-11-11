<?php


	namespace CivicInfoBC\EliMina;
	
	
	/**
	 *	A single item.
	 */
	class Item extends HasDimensions {
	
	
		/**
		 *	The name of the item.
		 */
		public $name;
		/**
		 *	The cost of the item.
		 */
		public $cost;
		/**
		 *	The weight of the item.
		 */
		public $weight;
		
		
		/**
		 *	Creates a new Item.
		 *
		 *	\param [in] $name
		 *		The name.
		 *	\param [in] $cost
		 *		The cost.
		 *	\param [in] $weight
		 *		The weight.
		 *	\param [in] $height
		 *		The height.
		 *	\param [in] $width
		 *		The width.
		 *	\param [in] $length
		 *		The length.
		 */
		public function __construct ($name, $cost, \CivicInfoBC\Measure $weight, \CivicInfoBC\Measure $height, \CivicInfoBC\Measure $width, \CivicInfoBC\Measure $length) {
		
			parent::__construct($height,$width,$length);
		
			$this->name=$name;
			$this->cost=$cost;
			$this->weight=$weight;
		
		}
	
	
	}


?>