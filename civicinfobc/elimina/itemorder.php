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
		 *		ordered.  Defaults to zero.
		 */
		public function __construct (Item $item, $quantity=0) {
		
			$this->item=$item;
			$this->quantity=$quantity;
		
		}
	
	
	}


?>