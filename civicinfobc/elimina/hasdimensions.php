<?php


	namespace CivicInfoBC\EliMina;
	
	
	/**
	 *	A base class for objects which have physical
	 *	dimensions.
	 */
	class HasDimensions {
	
	
		private $height;
		private $width;
		private $length;
		private $volume;
		
		
		/**
		 *	Creates a new object with dimensions.
		 *
		 *	\param [in] $height
		 *		The height of the object.
		 *	\param [in] $width
		 *		The width of the object.
		 *	\param [in] $length
		 *		The length of the object.
		 */
		public function __construct (\CivicInfoBC\Measure $height, \CivicInfoBC\Measure $width, \CivicInfoBC\Measure $length) {
		
			$this->height=$height->To('mm')->quantity;
			$this->width=$width->To('mm')->quantity;
			$this->length=$length->To('mm')->quantity;
			$this->volume=$this->height*$this->width*$this->length;
		
		}
		
		
		/**
		 *	Retrieves the height of the object, in millimeters.
		 *
		 *	\return
		 *		The height.
		 */
		public function Height () {
		
			return $this->height;
		
		}
		
		
		/**
		 *	Retrieves the width of the object, in millimeters.
		 *
		 *	\return
		 *		The width.
		 */
		public function Width () {
		
			return $this->width;
		
		}
		
		
		/**
		 *	Retrieves the length of the object, in millimeters.
		 *
		 *	\return
		 *		The length.
		 */
		public function Length () {
		
			return $this->length;
		
		}
		
		
		/**
		 *	Retrieves the volume of the object, in cubic
		 *	millimeters.
		 *
		 *	\return
		 *		The volume.
		 */
		public function Volume () {
		
			return $this->volume;
		
		}
	
	
	}


?>