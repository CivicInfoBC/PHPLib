<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	Represents the dimensions of a parcel.
	 *
	 *	All units in centimeters if numeric.
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
		
			$this->length=$length;
			$this->width=$width;
			$this->height=$height;
		
		}
		
		
		private static function get_float ($flt) {
		
			$flt=\CivicInfoBC\Convert::ToFloatOrThrow($flt);
			
			if (
				($flt<0) ||
				($flt>=1000)
			) throw new \InvalidArgumentException('Value out of range');
			
			return sprintf('%3.1f',$flt);
		
		}
		
		
		private static function to_measure (array $arr) {
		
			$retr=array();
			
			foreach ($arr as $x) {
			
				$retr[]=($x instanceof \CivicInfoBC\Measure) ? $x->To('cm')->quantity : $x;
			
			}
			
			sort($retr);
			
			return $retr;
		
		}
		
		
		private function to_array () {
		
			return self::to_measure(
				array(
					$this->length,
					$this->width,
					$this->height
				)
			);
		
		}
		
		
		public function Get (\DOMNode $node) {
		
			$doc=$node->ownerDocument;
			
			$node->appendChild($dim=$doc->createElement('dimensions'));
			
			$arr=$this->to_array();
			
			$dim->appendChild($doc->createElement('height',self::get_float($arr[0])));
			$dim->appendChild($doc->createElement('width',self::get_float($arr[1])));
			$dim->appendChild($doc->createElement('length',self::get_float($arr[2])));
		
		}
	
	
	}


?>