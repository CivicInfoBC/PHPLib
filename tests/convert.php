<?php


	namespace Tests;
	
	
	use \CivicInfoBC\Convert as C;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class Convert extends \CivicInfoBC\Testing\TestSuite {
	
	
		public static function date_time ($str, $expect_success, $throwing=false) {
		
			$dt=$throwing ? C::ToDateTimeOrThrow($str,'Y-m-d') : C::ToDateTime($str,'Y-m-d');
			if (is_null($dt)) return !$expect_success;
			if (!$expect_success) return false;
			
			return $dt->format('Y-m-d')===$str;
		
		}
	
	
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
				),
				new T(
					'Boolean (identity)',
					'ToBoolean leaves booleans untouched',
					function () {	return (C::ToBoolean(true)===true) && (C::ToBoolean(false)===false);	}
				),
				new T(
					'Boolean (integer, success)',
					'ToBoolean accepts integers with a lossless boolean representation (i.e. 0 and 1)',
					function () {	return (C::ToBoolean(1)===true) && (C::ToBoolean(0)===false);	}
				),
				new T(
					'Boolean (integer, failure)',
					'ToBoolean rejects integers without a lossless boolean representation',
					function () {	return is_null(C::ToBoolean(5));	}
				),
				new T(
					'Boolean (floating point, success)',
					'ToBoolean accepts floating point values with a lossless boolean representation (i.e. 0.0 and 1.0)',
					function () {	return (C::ToBoolean(1.0)===true) && (C::ToBoolean(0.0)===false);	}
				),
				new T(
					'Boolean (floating point, failure)',
					'ToBoolean rejects floating point values without a lossless boolean representation',
					function () {	return is_null(C::ToBoolean(5.5));	}
				),
				new T(
					'Boolean (string, success)',
					'ToBoolean accepts strings that represent boolean values (i.e. "true", "false", "yes", "no", et cetera)',
					function () {
					
						return (
							(C::ToBoolean('true')===true) &&
							(C::ToBoolean('false')===false) &&
							(C::ToBoolean('t')===true) &&
							(C::ToBoolean('f')===false) &&
							(C::ToBoolean('TRUE')===true) &&
							(C::ToBoolean('FALSE')===false) &&
							(C::ToBoolean('T')===true) &&
							(C::ToBoolean('F')===false) &&
							(C::ToBoolean('yes')===true) &&
							(C::ToBoolean('no')===false) &&
							(C::ToBoolean('y')===true) &&
							(C::ToBoolean('n')===false) &&
							(C::ToBoolean('YES')===true) &&
							(C::ToBoolean('NO')===false) &&
							(C::ToBoolean('Y')===true) &&
							(C::ToBoolean('N')===false)
						);
					
					}
				),
				new T(
					'Boolean (string, success, whitespace)',
					'ToBoolean accepts strings that represent a boolean value despite leading and/or trailing whitespace',
					function () {	return C::ToBoolean('     true     ')===true;	}
				),
				new T(
					'Boolean (string, almost success)',
					'ToBoolean rejects strings even if they have a representation of a boolean value as a substring',
					function () {	return is_null(C::ToBoolean('that\'s true'));	}
				),
				new T(
					'Boolean (string, failure)',
					'ToBoolean rejects string which do not represent a boolean value',
					function () {	return is_null(C::ToBoolean('baby bears'));	}
				),
				new T(
					'Boolean (throwing, success)',
					'ToBooleanOrThrow returns a boolean on success',
					function () {	return C::ToBooleanOrThrow('true')===true;	}
				),
				new T(
					'Boolean (throwing, failure)',
					'ToBooleanOrThrow throws on failure',
					function () {	C::ToBooleanOrThrow('falsey');	},
					true
				),
				new T(
					'DateTime (success)',
					'ToDateTime returns an appropriate DateTime object on success',
					function () {	return Convert::date_time('2014-02-04',true);	}
				),
				new T(
					'DateTime (failure)',
					'ToDateTime rejects strings that do not contain a date and a time, or which do not contain one according to its format',
					function () {
					
						return (
							Convert::date_time('hello world',false) &&
							Convert::date_time('2014-99-99',false)
						);
					
					}
				),
				new T(
					'DateTime (throwing, success)',
					'ToDateTimeOrThrow returns a DateTime on success',
					function () {	return Convert::date_time('2014-02-04',true,true);	}
				),
				new T(
					'DateTime (throwing, failure)',
					'ToDateTimeorThrow throws on failure',
					function () {	Convert::date_time('hello world',false,true);	},
					true
				)
			);
		
		}
	
	
	}


?>