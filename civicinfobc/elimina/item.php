<?php


	namespace CivicInfoBC\EliMina;
	
	
	/**
	 *	A single item.
	 */
	class Item {
	
	
		/**
		 *	The name of the item.
		 */
		public $name;
		/**
		 *	The weight of the item.
		 */
		public $weight;
		/**
		 *	The height of the item
		 *	(for packing purposes).
		 */
		public $height;
		
		
		/**
		 *	Creates a new Item.
		 *
		 *	\param [in] $name
		 *		The name.
		 *	\param [in] $weight
		 *		The weight.
		 *	\param [in] $height
		 *		The height.
		 */
		public function __construct ($name, \CivicInfoBC\Measure $weight, \CivicInfoBC\Measure $height) {
		
			$this->name=$name;
			$this->weight=$weight;
			$this->height=$height;
		
		}
	
	
	}


?>