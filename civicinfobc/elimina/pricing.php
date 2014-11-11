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
		 *	Tax rate.
		 */
		public $tax_rate;
		/**
		 *	Any applied discounts.
		 */
		public $discounts=array();
		
		
		/**
		 *	Creates a new Pricing object.
		 *
		 *	Initializes all properties to zero
		 *	(floating point).
		 */
		public function __construct () {
		
			$this->subtotal=0.0;
			$this->shipping=0.0;
			$this->tax_rate=0.0;
		
		}
		
		
		/**
		 *	Retrieves the total discount for the order.
		 *
		 *	\return
		 *		The discount.
		 */
		public function Discount () {
		
			$retr=0.0;
			foreach ($this->discounts as $discount) $retr+=$discount->amount;
			
			return $retr;
		
		}
		
		
		/**
		 *	Retrieves the tax for the order.
		 *
		 *	\return
		 *		The tax.
		 */
		public function Tax () {
		
			return round(($this->subtotal+$this->shipping-$this->Discount())*$this->tax_rate,2);
		
		}
		
		
		/**
		 *	Retrieves the total for the order.
		 *
		 *	\return
		 *		The total price.
		 */
		public function Total () {
		
			return round($this->subtotal+$this->shipping-$this->Discount()+$this->Tax(),2);
		
		}
	
	
	}


?>