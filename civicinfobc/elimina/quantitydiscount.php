<?php


	namespace CivicInfoBC\EliMina;
	
	
	/**
	 *	A discount that is applied based on the number
	 *	of items ordered.
	 */
	class QuantityDiscount implements Discount {
	
	
		private $min;
		private $max;
		private $amount;
		
		
		/**
		 *	Creates a new QuantityDiscount.
		 *
		 *	\param [in] $min
		 *		The minimum (inclusive) number of books to apply
		 *		this discount to.  \em null for no minimum.
		 *	\param [in] $max
		 *		The maximum (inclusive) number of books to apply
		 *		this discount to.  \em null for no maximum.
		 *	\param [in] $amount
		 *		The percentage discount to apply.
		 */
		public function __construct ($min, $max, $amount) {
		
			$this->min=$min;
			$this->max=$max;
			$this->amount=$amount;
		
		}
		
		
		private function description () {
		
			$retr=sprintf('%.0f%% discount',round($this->amount*100,0));
			
			if (is_null($this->min) && is_null($this->max)) return $retr;
			
			$retr.=' for buying ';
			
			if (is_null($this->min)) {
			
				$retr.=sprintf('%s items or less',$this->max);
			
				return $retr;
			
			}
			
			if (is_null($this->max)) {
			
				$retr.=sprintf('%s items or more',$this->min);
				
				return $retr;
			
			}
			
			$retr.=sprintf('between %s and %s items',$this->min,$this->max);
			
			return $retr;
		
		}
		
		
		public function Apply (Pricing $pricing, array $items) {
		
			$total=0;
			foreach ($items as $item) $total+=$item->quantity;
			
			if (
				!is_null($this->min) &&
				($total<$this->min)
			) return;
			
			if (
				!is_null($this->max) &&
				($total>$this->max)
			) return;
			
			$pricing->discounts[]=new DiscountDetails(
				$this->description(),
				round($pricing->subtotal*$this->amount,2)
			);
		
		}
	
	
	}


?>