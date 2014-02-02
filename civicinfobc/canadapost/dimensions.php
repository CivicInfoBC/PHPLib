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
		
		
		public function __construct ($length, $width, $height) {
		
			$this->length=$length;
			$this->width=$width;
			$this->height=$height;
		
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