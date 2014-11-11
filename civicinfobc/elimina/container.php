<?php


	namespace CivicInfoBC\EliMina;
	
	
	/**
	 *	A container into which items may be packed.
	 */
	class Container extends HasDimensions {
	
	
		private static $volume_scale_factor=0.6;
		
		
		private $height;
		private $width;
		private $length;
	
	
		/**
		 *	The name of the container.
		 */
		public $name;
		/**
		 *	The cost of the container.
		 */
		public $cost;
		
		
		/**
		 *	Creates a new Container.
		 *
		 *	\param [in] $name
		 *		The name.
		 *	\param [in] $cost
		 *		The cost.
		 *	\param [in] $height
		 *		The height.
		 *	\param [in] $width
		 *		The width.
		 *	\param [in] $length
		 *		The length.
		 */
		public function __construct ($name, $cost, \CivicInfoBC\Measure $height, \CivicInfoBC\Measure $width, \CivicInfoBC\Measure $length) {
		
			parent::__construct($height,$width,$length);
		
			$this->name=$name;
			$this->cost=$cost;
			$this->height=$height;
			$this->width=$width;
			$this->length=$length;
		
		}
		
		
		private static function copy (array $items) {
		
			$retr=array();
			foreach ($items as $item) $retr[]=clone $item;
			
			return $retr;
		
		}
		
		
		/**
		 *	Attempts to pack this container with items from
		 *	an array of ItemOrder objects.
		 *
		 *	\param [in] $items
		 *		An array of ItemOrder objects.
		 */
		public function Pack (array $items) {
		
			$items=self::copy($items);
			$packed=array();
			$volume=$this->Volume()*self::$volume_scale_factor;
			foreach ($items as $key=>&$item) {
			
				$p=new ItemOrder($item->item);
				$v=$item->item->Volume();
				while (($volume>=$v) && ($item->quantity!==0)) {
				
					$volume-=$v;
					--$item->quantity;
					++$p->quantity;
				
				}
				
				if ($item->quantity===0) unset($items[$key]);
				
				if ($p->quantity!==0) $packed[]=$p;
			
			}
			
			return new PackResult($this,$packed,array_values($items));
		
		}
		
		
		/**
		 *	Gets a partially populated CanadaPost\\Parcel
		 *	object representing this container.
		 *
		 *	\return
		 *		A CanadaPost\\Parcel object.
		 */
		public function Parcel () {
		
			$retr=new \CivicInfoBC\CanadaPost\Parcel();
			$retr->dimensions=new \CivicInfoBC\CanadaPost\Dimensions($this->length,$this->width,$this->height);
			
			return $retr;
		
		}
	
	
	}


?>