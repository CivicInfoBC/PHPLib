<?php


	namespace CivicInfoBC\EliMina;
	
	
	/**
	 *	The pricing of an order.
	 */
	class Pricing {
	
	
		/**
		 *	The price excluding taxes,
		 *	shipping, and handling.
		 */
		public $subtotal;
		/**
		 *	Shipping and handling costs.
		 */
		public $shipping;
		/**
		 *	Taxes.
		 */
		public $tax;
		/**
		 *	The total.
		 */
		public $total;
		
		
		/**
		 *	Creates a new Pricing object.
		 *
		 *	Initializes all properties to zero
		 *	(floating point).
		 */
		public function __construct () {
		
			$this->subtotal=0.0;
			$this->shipping=0.0;
			$this->tax=0.0;
			$this->total=0.0;
		
		}
	
	
	}


?>