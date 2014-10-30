<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Attempts to pack items into an infinite number
	 *	of differently sized containers.
	 */
	class Packer {
	
	
		private $boxes=array();
		private $original_boxes;
		
		
		private static function to_measure ($measure) {
		
			if ($measure instanceof Measure) return $measure->To('cm')->quantity;
			
			return $measure;
		
		}
		
		
		private static function to_array ($obj) {
		
			return array(
				'height' => self::to_measure($obj->height),
				'width' => self::to_measure($obj->width),
				'length' => self::to_measure($obj->length)
			);
		
		}
		
		
		private static function to_item_array (array $items) {
		
			$retr=array();
			$c=count($items);
			for ($i=0;$i<$c;++$i) $retr[]=array_merge(
				array('index' => $i),
				self::to_array(new KeyValueWrapper($items[$i]))
			);
			
			return $retr;
		
		}
		
		
		/**
		 *	Creates a new Packer.
		 *
		 *	\param [in] $boxes
		 *		An array of boxes in which the Packer shall
		 *		attempt to pack boxes.  Each box shall have
		 *		all three of \em height, \em width, and
		 *		\em length, which shall give the dimensions of
		 *		the box in consistent units.
		 */
		public function __construct (array $boxes) {
		
			$c=count($boxes);
		
			if ($c===0) throw new \LogicException('Zero boxes');
			
			$this->original_boxes=$boxes;
			$this->boxes=self::to_item_array($boxes);
		
		}
		
		
		private function get_packings (array $items) {
		
			$retr=array();
			foreach ($this->boxes as $box) {
			
				$laff=new LAFFPack();
				$laff->pack($items,$box);
				
				var_dump($laff);
				
				$packed=$laff->get_packed_boxes()[0];
				if (count($packed)===0) continue;
				
				$obj=new \stdClass();
				$obj->packed=$packed;
				$obj->unpacked=$laff->get_remaining_boxes();
				$obj->box=$box;
				$obj->volume=$laff->get_packed_volume();
				$obj->remaining_volume=$laff->get_remaining_volume();
				
				//var_dump($obj);
				
				$retr[]=$obj;
			
			}
			
			return $retr;
		
		}
		
		
		private static function select_most (array $packings) {
		
			$retr=array();
			$max=0;
			foreach ($packings as $packing) {
			
				$packed=count($packing->packed);
				if ($packed<$max) continue;
				if ($packed===$max) {
				
					$retr[]=$packing;
					
					continue;
				
				}
				
				$retr=array($packing);
			
			}
			
			return $retr;
		
		}
		
		
		private static function select_most_efficient (array $packings) {
		
			$retr=$packings[0];
			$c=count($packings);
			for ($i=1;$i<$c;++$i) {
			
				$packing=$packings[$i];
				
				if ($packing->remaining_volume>=$retr->remaining_volume) continue;
				
				$retr=$packing;
			
			}
			
			return $retr;
		
		}
		
		
		private static function select_best (array $packings) {
		
			return self::select_most_efficient(
				self::select_most($packings)
			);
		
		}
		
		
		private function to_pack_result ($obj, array $items) {
		
			$retr=new PackResult();
			foreach ($obj->packed as $item) $retr->packed[]=$items[$item['index']];
			$retr->container=$this->original_boxes[$obj->box['index']];
			
			return $retr;
		
		}
		
		
		private static function trim ($obj, array $items) {
		
			$retr=array();
			foreach ($obj->unpacked as $item) $retr[]=$items[$item['index']];
			
			return $retr;
		
		}
		
		
		/**
		 *	Attempts to pack items into containers.
		 *
		 *	\param [in] $items
		 *		An array of items.  Each item shall have
		 *		a \em height, \em width, and \em length
		 *		property, which shall give the dimensions of
		 *		the item in units consistent with those used
		 *		to specify the boxes.
		 *
		 *	\return
		 *		An array of PackResult objects, specifying how
		 *		the items were packed.
		 */
		public function Pack (array $items) {
			
			if (count($items)===0) return array();
			
			$packings=$this->get_packings(
				self::to_item_array($items)
			);
			if (count($packings)===0) throw new \Exception(
				'Cannot pack items into any container'
			);
			
			$packing=self::select_best($packings);
			$result=$this->to_pack_result($packing,$items);
			$arr=self::trim($packing,$items);
			
			return array_merge(
				array($result),
				$this->Pack($arr)
			);
		
		}
	
	
	}


?>