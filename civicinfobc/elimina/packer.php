<?php


	namespace CivicInfoBC\EliMina;
	
	
	/**
	 *	Packs items into containers, using heuristics to find
	 *	a semi-optimal packing.
	 */
	class Packer {
	
	
		private $boxes;
		
		
		/**
		 *	Creates a new Packer which attempts to pack items
		 *	into certain types of boxes.
		 *
		 *	\param [in] $boxes
		 *		An array of Container objects which give the
		 *		types of containers.
		 */
		public function __construct (array $boxes) {
		
			$this->boxes=$boxes;
		
		}
		
		
		private static function select_max (array $alternatives) {
		
			$retr=array();
			$max=0;
			foreach ($alternatives as $alternative) {
			
				$c=0;
				foreach ($alternative->packed as $packed) $c+=$packed->quantity;
			
				if ($c<$max) continue;
				if ($c===$max) {
				
					$retr[]=$alternative;
					
					continue;
				
				}
				
				$retr=array($alternative);
				$max=$c;
			
			}
			
			return $retr;
		
		}
		
		
		private static function select_min (array $alternatives) {
		
			$min=$alternatives[0];
			for ($i=1;$i<count($alternatives);++$i) {
			
				if ($alternatives[$i]->RemainingVolume()>=$min->RemainingVolume()) continue;
				
				$min=$alternatives[$i];
			
			}
			
			return $min;
		
		}
		
		
		private static function select_best (array $alternatives) {
		
			$alternatives=self::select_max($alternatives);
			
			return self::select_min($alternatives);
		
		}
		
		
		/**
		 *	Attempts to pack items into boxes.
		 *
		 *	\param [in] $items
		 *		An array of ItemOrder objects giving the
		 *		items to be packed.
		 *
		 *	\return
		 *		An array of PackResult objects specifying
		 *		how the items were packed.
		 */
		public function Pack (array $items) {
		
			if (count($items)===0) return array();
			
			$alternatives=array();
			foreach ($this->boxes as $box) {
			
				$alternative=$box->Pack($items);
				if (count($alternative->packed)!==0) $alternatives[]=$alternative;
			
			}
			
			if (count($alternatives)===0) throw new \Exception('Could not pack order in any container');
			
			$p=self::select_best($alternatives);
			
			return array_merge(
				array($p),
				$this->Pack($p->unpacked)
			);
		
		}
	
	
	}


?>