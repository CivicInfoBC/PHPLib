<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	Represents the dimensions of a parcel.
	 *
	 *	All units in centimeters.
	 */
	class Dimensions {
	
	
		/**
		 *	Defined by Canada Post to be the longest
		 *	dimension of the parcel.
		 */
		public $length;
		/**
		 *	Defined by Canada Post to be the second
		 *	longest dimension of the parcel.
		 */
		public $width;
		/**
		 *	Defined by Canada Post to be the shortest
		 *	dimension of the parcel.
		 */
		public $height;
		
		
		/**
		 *	Creates a new Dimensions object.
		 *
		 *	If the parameters are not passed in the
		 *	order the Canada Post XML API expects them,
		 *	they will automatically be reordered.
		 *
		 *	\param [in] $length
		 *		The length.
		 *	\param [in] $width
		 *		The width.
		 *	\param [in] $height
		 *		The height.
		 */
		public function __construct ($length, $width, $height) {
		
			//	Canada Post has a special definition for
			//	"length", "width", and "height", we ensure
			//	that's reflected in the way we populate
			//	this class
			$arr=array($length,$width,$height);
			rsort($arr);
			
			$this->length=$arr[0];
			$this->width=$arr[1];
			$this->height=$arr[2];
		
		}
		
		
		private function get_float ($flt) {
		
			if (!is_numeric($flt)) throw new \Exception('Value not numeric');
			
			$flt=floatval($flt);
			
			if (
				($flt<0) ||
				($flt>=1000)
			) throw new \Exception('Value out of range');
			
			return sprintf('%5.3f',$flt);
		
		}
		
		
		public function Get (\DOMNode $node) {
		
			$doc=$node->ownerDocument;
			
			$node->appendChild($dim=$doc->createElement('dimensions'));
			
			$dim->appendChild($doc->createElement('length',self::get_float($this->length)));
			$dim->appendChild($doc->createElement('width',self::get_float($this->width)));
			$dim->appendChild($doc->createElement('height',self::get_float($this->height)));
		
		}
	
	
	}


?>