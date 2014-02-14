<?php


	namespace CivicInfoBC\EliMina;
	
	
	/**
	 *	Represents an order of a single item.
	 */
	class ItemOrder {
	
	
		/**
		 *	The item being ordered.
		 */
		public $item;
		/**
		 *	The number of that item being
		 *	ordered.
		 */
		public $quantity;
		
		
		/**
		 *	Creates a new ItemOrder.
		 *
		 *	\param [in] $item
		 *		The item.
		 *	\param [in] $quantity
		 *		The number of the item being
		 *		ordered.
		 */
		public function __construct (Item $item, $quantity) {
		
			$this->item=$item;
			$this->quantity=$quantity;
		
		}
	
	
	}


?>