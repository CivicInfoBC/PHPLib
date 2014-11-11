<?php


	namespace CivicInfoBC\EliMina;
	
	
	/**
	 *	Encapsulates the result of packing a single
	 *	container.
	 */
	class PackResult {
	
	
		/**
		 *	The container.
		 */
		public $container;
		/**
		 *	An array of ItemOrder objects giving the
		 *	items that were packed into this container.
		 */
		public $packed;
		/**
		 *	An array of ItemOrder objects giving the items
		 *	that were not packed into this container.
		 */
		public $unpacked;
		
		
		/**
		 *	Creates a new PackResult object.
		 *
		 *	\param [in] $container
		 *		The container into which objects were
		 *		packed.
		 *	\param [in] $packed
		 *		An array of ItemOrder objects giving the
		 *		items that were packed into the container.
		 *	\param [in] $unpacked
		 *		An array of ItemOrder objects giving the items
		 *		that were not packed into the container.
		 */
		public function __construct (Container $container, array $packed, array $unpacked) {
		
			$this->container=$container;
			$this->packed=$packed;
			$this->unpacked=$unpacked;
		
		}
		
		
		/**
		 *	Determines the amount of unused volume in the
		 *	packed container.
		 *
		 *	\return
		 *		The unused volume in cubic millimeters.
		 */
		public function RemainingVolume () {
		
			$volume=$this->container->Volume();
			foreach ($this->packed as $item) $volume-=$item->item->Volume()*$item->quantity;
			
			return $volume;
		
		}
		
		
		/**
		 *	Gets a CanadaPost\\Parcel object representing this
		 *	packed container.
		 *
		 *	\return
		 *		A CanadaPost\\Parcel object.
		 */
		public function Parcel () {
		
			$retr=$this->container->Parcel();
			
			$retr->weight=0.0;
			foreach ($this->packed as $item) $retr->weight+=$item->item->weight->To('kg')->quantity*$item->quantity;
			
			return $retr;
		
		}
	
	
	}


?>