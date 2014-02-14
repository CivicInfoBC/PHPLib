<?php


	namespace CivicInfoBC\EliMina;
	
	
	/**
	 *	Represents a container in which items
	 *	might be shipped.
	 */
	class Container {
	
	
		/**
		 *	The name of this container.
		 */
		public $name;
		/**
		 *	The cost of this container.
		 */
		public $cost;
		/**
		 *	The dimensions of this container for
		 *	use in shipping calculations.
		 */
		public $dimensions;
		/**
		 *	The weight of this container for use
		 *	in shipping calculations.
		 */
		public $weight;
		/**
		 *	The maximum number of items which may
		 *	be placed in this container, or \em null
		 *	if the capacity of this container
		 *	depends only on its height.
		 */
		public $max;
		/**
		 *	The height of this container for use
		 *	in deciding whether a given order
		 *	will fit, or \em null if the capacity
		 *	depends only on the number of items.
		 */
		public $height;
		
		
		public function __construct (
			$name,
			$cost,
			$max,
			\CivicInfoBC\CanadaPost\Dimensions $dimensions,
			\CivicInfoBC\Measure $height=null,
			\CivicInfoBC\Measure $weight=null
		) {
		
			$this->name=$name;
			$this->cost=$cost;
			$this->max=$max;
			$this->dimensions=$dimensions;
			$this->height=$height;
			$this->weight=$weight;
		
		}
		
		
		private function get_copy (\CivicInfoBC\Measure $height) {
		
			$retr=$this;
		
			foreach ($this->dimensions as $key=>&$value) {
			
				if (is_null($value)) {
				
					if ($retr===$this) $retr=clone $this;
					
					$retr->dimensions->$key=$height;
				
				}
			
			}
			
			return $retr;
		
		}
		
		
		public function Get ($order) {
		
			$order=\CivicInfoBC\ArrayUtil::Coalesce($order);
			
			//	Get totals for the order -- total height
			//	and total number of items
			$total=0;
			$height=new \CivicInfoBC\Measure('0cm');
			foreach ($order as $item) {
			
				$height=$height->Add(
					$item->item->height->Multiply(
						$item->quantity
					)
				);
				$total+=$item->quantity;
			
			}
			
			//	If there's too many items, or the
			//	items are too tall, fail
			if (
				(
					!is_null($this->max) &&
					($total>$this->max)
				) ||
				(
					!is_null($this->height) &&
					($this->height->Compare($height)<0)
				)
			) return null;
			
			//	Return
			return $this->get_copy($height);
		
		}
	
	
	}


?>