<?php


	namespace Tests;
	
	
	use \CivicInfoBC\Convert as C;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class Convert extends \CivicInfoBC\Testing\TestSuite {
	
	
		public function __construct () {
		
			parent::__construct('Conversion Utilities');
			
			$this->tester->tests=array(
				new T(
					'Integer (identity)',
					'ToInteger leaves integers untouched',
					function () {
					
						$i=5;
						return C::ToInteger($i)===$i;
					
					}
				),
				new T(
					'Integer (integer floating point)',
					'ToInteger accepts floating point values with no fractional component',
					function () {	return C::ToInteger(floatval(5))===5;	}
				),
				new T(
					'Integer (non-integer floating point)',
					'ToInteger rejects floating point values with fractional component',
					function () {	return is_null(C::ToInteger(5.5));	}
				),
				new T(
					'Integer (boolean)',
					'ToInteger converts boolean values to 0 or 1',
					function () {	return (C::ToInteger(true)===1) && (C::ToInteger(false)===0);	}
				),
				new T(
					'Integer (integer string)',
					'ToInteger accepts a string containing an integer',
					function () {	return C::ToInteger('5')===5;	}
				),
				new T(
					'Integer (floating point string)',
					'ToInteger rejects a string containing a floating point value',
					function () {	return is_null(C::ToInteger('5.5'));	}
				),
				new T(
					'Integer (partially numeric string)',
					'ToInteger rejects strings which are partially numeric',
					function () {	return is_null(C::ToInteger('5 kites'));	}
				),
				new T(
					'Integer (non-numeric string)',
					'ToInteger rejects strings which are not numeric',
					function () {	return is_null(C::ToInteger('hello world'));	}
				),
				new T(
					'Integer (throwing, success)',
					'ToIntegerOrThrow returns an integer on success',
					function () {	return C::ToIntegerOrThrow(5)===5;	}
				),
				new T(
					'Integer (throwing, failure)',
					'ToIntegerOrThrow throws on failure',
					function () {	C::ToIntegerOrThrow('hello');	},
					true
				),
				new T(
					'Float (identity)',
					'ToFloat leaves floats untouched',
					function () {
						
						$f=5.5;
						return C::ToFloat($f)===$f;
						
					}
				),
				new T(
					'Float (integer)',
					'ToFloat accepts integers',
					function () {	return C::ToFloat(5)===5.0;	}
				),
				new T(
					'Float (boolean)',
					'ToFloat converts boolean values to 0.0 or 1.0',
					function () {	return (C::ToFloat(true)===1.0) && (C::ToFloat(false)===0.0);	}
				),
				new T(
					'Float (integer string)',
					'ToFloat accepts strings containing integers',
					function () {	return C::ToFloat('5')===5.0;	}
				),
				new T(
					'Float (floating point string)',
					'ToFloat accepts strings containing floating point values',
					function () {	return C::ToFloat('5.5')===5.5;	}
				),
				new T(
					'Float (partially numeric string)',
					'ToFloat rejects strings which are partially numeric',
					function () {	return is_null(C::ToFloat('5 kites'));	}
				),
				new T(
					'Float (non-numeric string)',
					'ToFloat rejects strings which are not numeric',
					function () {	return is_null(C::ToFloat('hello world'));	}
				),
				new T(
					'Float (throwing, success)',
					'ToFloatOrThrow returns a float on success',
					function () {	return C::ToFloatOrThrow(5)===5.0;	}
				),
				new T(
					'Float (throwing, failure)',
					'ToFloatOrThrow throws on failure',
					function () {	C::ToFloatOrThrow('hello');	},
					true
				)
			);
		
		}
	
	
	}


?>