<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for safely converting
	 *	between different types.
	 */
	class Convert {
	
	
		/**
		 *	Attempts to convert an arbitrary input
		 *	to an integer.
		 *
		 *	Fails if such a conversion cannot be
		 *	performed losslessly.
		 *
		 *	The conversion of boolean \em true and
		 *	\em false to 1 and 0 (respectively) is
		 *	not considered lossy.
		 *
		 *	\param [in] $obj
		 *		The input to attempt to convert to
		 *		an integer.
		 *	\param [in] $default
		 *		A default value to return if \em obj
		 *		is not convertible to an integer.
		 *		Defaults to \em null.
		 *
		 *	\return
		 *		The lossless integer representation of
		 *		\em obj, if such a representation exists,
		 *		\em default otherwise.
		 */
		public static function ToInteger ($obj, $default=null) {
		
			if (is_integer($obj)) return $obj;
			
			if (is_float($obj)) {
			
				$i=intval($obj);
				
				if (floatval($i)===$obj) return $i;
				
				return $default;
			
			}
			
			if (is_bool($obj)) return $obj ? 1 : 0;
			
			if (
				is_numeric($obj) &&
				(($retr=intval($obj))==floatval($obj))
			) return $retr;
			
			return $default;
		
		}
		
		
		/**
		 *	Identical to ToInteger, except throws on failure.
		 *
		 *	\param [in] $obj
		 *		The input to attempt to convert to an
		 *		integer.
		 *
		 *	\return
		 *		The lossless integer representation of
		 *		\em obj.
		 */
		public static function ToIntegerOrThrow ($obj) {
		
			if (is_null($retr=self::ToInteger($obj))) throw new \Exception(
				sprintf(
					'%s cannot be converted to an integer',
					$obj
				)
			);
			
			return $retr;
		
		}
		
		
		/**
		 *	Attempts to convert an arbitrary input
		 *	to a floating point value.
		 *
		 *	Fails if such a conversion cannot be
		 *	performed losslessly.
		 *
		 *	The conversion of boolean \em true and
		 *	\em false to 1.0 and 0.0 (respectively) is
		 *	not considered lossy.
		 *
		 *	\param [in] $obj
		 *		The input to attempt to convert to
		 *		a floating point value.
		 *	\param [in] $default
		 *		A default value to return if \em obj
		 *		is not convertible to a floating point
		 *		value.  Defaults to \em null.
		 *
		 *	\return
		 *		The lossless floating point representation of
		 *		\em obj, if such a representation exists,
		 *		\em default otherwise.
		 */
		public static function ToFloat ($obj, $default=null) {
		
			if (is_float($obj)) return $obj;
		
			if (is_integer($obj)) return floatval($obj);
			
			if (is_bool($obj)) return floatval($obj ? 1 : 0);
			
			if (is_numeric($obj)) return floatval($obj);
			
			return $default;
		
		}
		
		
		/**
		 *	Identical to ToFloat, except throws on failure.
		 *
		 *	\param [in] $obj
		 *		The input to attempt to convert to a
		 *		floating point value.
		 *
		 *	\return
		 *		The lossless floating point representation of
		 *		\em obj.
		 */
		public static function ToFloatOrThrow ($obj) {
		
			if (is_null($retr=self::ToFloat($obj))) throw new \Exception(
				sprintf(
					'%s cannot be converted to a floating point value',
					$obj
				)
			);
			
			return $retr;
		
		}
		
		
		/**
		 *	Attempts to convert an arbitrary input
		 *	to a floating point value.
		 *
		 *	Fails if such a conversion cannot be
		 *	performed losslessly.
		 *
		 *	Strings containing \"true\", \"t\", \"yes\",
		 *	and \"y\" are considered to losslessly
		 *	convert to \em true.
		 *
		 *	String containing \"false\", \"f\", \"no\",
		 *	and \"n\" are considered to losslessly convert
		 *	to \em false.
		 *
		 *	\param [in] $obj
		 *		The input to attempt to convert to
		 *		a boolean.
		 *	\param [in] $default
		 *		A default value to return if \em obj
		 *		is not convertible to a boolean.
		 *		Defaults to \em null.
		 *
		 *	\return
		 *		The lossless boolean representation of
		 *		\em obj, if such a representation exists,
		 *		\em default otherwise.
		 */
		public static function ToBoolean ($obj, $default=null) {
		
			if (is_bool($obj)) return $obj;
		
			if (is_float($obj)) {
			
				if ($obj===0.0) return false;
				if ($obj===1.0) return true;
				
				return null;
			
			}
			
			if (is_integer($obj)) {
			
				if ($obj===0) return false;
				if ($obj===1) return true;
				
				return null;
			
			}
			
			if (Regex::IsMatch(
				'/^\\s*(?:t(?:rue)?|y(?:es)?)\\s*$/ui',
				$obj
			)) return true;
			
			if (Regex::IsMatch(
				'/^\\s*(?:f(?:alse)?|no?)\\s*$/ui',
				$obj
			)) return false;
			
			return null;
		
		}
		
		
		/**
		 *	Identical to ToBoolean, except throws on failure.
		 *
		 *	\param [in] $obj
		 *		The input to attempt to convert to a
		 *		boolean.
		 *
		 *	\return
		 *		The lossless boolean representation of
		 *		\em obj.
		 */
		public static function ToBooleanOrThrow ($obj) {
		
			if (is_null($retr=self::ToBoolean($obj))) throw new \Exception(
				sprintf(
					'%s cannot be converted to a boolean value',
					$obj
				)
			);
			
			return $retr;
		
		}
		
		
		private static function date_time_is_error (array $arr) {
		
			return !(($arr['warning_count']===0) && ($arr['error_count']===0));
		
		}
		
		
		/**
		 *	Attempts to convert a string to a DateTime
		 *	object according to a specified format.
		 *
		 *	\param [in] $str
		 *		The string which supposedly contains a
		 *		date/time representation.
		 *	\param [in] $format
		 *		The format \em str supposedly is in.
		 *		Token from DateTime::createFromFormat.
		 *	\param [in] $default
		 *		The value to return if \em str cannot
		 *		be converted to a DateTime according to
		 *		\em format.
		 *
		 *	\return
		 *		A DateTime object containing the date
		 *		and time information represented by
		 *		\em str if a valid such representation
		 *		exists, \em default otherwise.
		 */
		public static function ToDateTime ($str, $format, $default=null) {
		
			return (
				(($retr=\DateTime::createFromFormat($format,$str))===false) ||
				self::date_time_is_error(\DateTime::getLastErrors())
			) ? $default : $retr;
		
		}
		
		
		private static function get_date_time_error ($prefix, array $arr, $curr='') {
		
			foreach ($arr as $char=>$msg) {
			
				if ($curr!=='') $curr.='; ';
				$curr.=sprintf(
					'%s: %s at offset %s',
					$prefix,
					$msg,
					$char
				);
			
			}
			
			return $curr;
		
		}
		
		
		/**
		 *	Identical to ToDateTime, except throws on error.
		 *
		 *	\param [in] $str
		 *		The string which supposedly contains a
		 *		date/time representation.
		 *	\param [in] $format
		 *		The format \em str supposedly is in.
		 *		Token from DateTime::createFromFormat.
		 *
		 *	\return
		 *		A DateTime object containing the date and
		 *		time information represented by \em str.
		 */
		public static function ToDateTimeOrThrow ($str, $format) {
		
			$retr=\DateTime::createFromFormat($format,$str);
			
			$arr=\DateTime::getLastErrors();
			
			if (!(
				($retr===false) ||
				self::date_time_is_error($arr)
			)) return $retr;
			
			//	ERROR
			
			$str=sprintf(
				'"%s" could not be converted to a DateTime with format string "%s"',
				$str,
				$format
			);
			$errors=self::get_date_time_error(
				'ERROR',
				$arr['errors'],
				self::get_date_time_error(
					'WARNING',
					$arr['warnings']
				)
			);
			if ($errors!=='') $str.=': '.$errors;
			
			throw new \Exception($str);
		
		}
	
	
	}


?>