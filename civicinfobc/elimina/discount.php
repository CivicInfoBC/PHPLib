<?php


	namespace CivicInfoBC\EliMina;
	
	
	/**
	 *	Represents a discount which may be applied to
	 *	an order.
	 */
	interface Discount {
	
	
		/**
		 *	Applies the discount to a Pricing object.
		 *
		 *	\param [in] $pricing
		 *		The Pricing object.
		 *	\param [in] $order
		 *		An array of ItemOrder objects giving the
		 *		objects being ordered.
		 */
		public function Apply (Pricing $pricing, array $order);
	
	
	};


?>