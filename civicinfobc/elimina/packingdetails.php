<?php


	namespace CivicInfoBC\EliMina;


	/**
	 *	Details of a packed order.
	 */
	class PackingDetails {
	
	
		/**
		 *	The total number of items.
		 */
		public $total;
		/**
		 *	The total weight of the packed
		 *	container.
		 */
		public $weight;
		/**
		 *	The container the order will be
		 *	packed in.
		 */
		public $container;
		
		
		/**
		 *	Creates a new PackingDetails object.
		 *
		 *	\param [in] $total
		 *		The total number of items.
		 *	\param [in] $weight
		 *		The weight.
		 *	\param [in] $container
		 *		The container.
		 */
		public function __construct ($total, \CivicInfoBC\Measure $weight, Container $container) {
		
			$this->total=$total;
			$this->weight=$weight;
			$this->container=$container;
		
		}
	
	
	}


?>