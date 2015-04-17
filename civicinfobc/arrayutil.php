<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for performing operations
	 *	on arrays.
	 */
	class ArrayUtil {
	
	
		/**
		 *	Coalesces a value to an array.
		 *
		 *	If the value is not an array, a new array
		 *	containing it as the only element will be
		 *	created and returned.
		 *
		 *	\param [in] $arr
		 *		The array or value.
		 *
		 *	\return
		 *		The coalesced value.
		 */
		public static function Coalesce ($arr) {
		
			if (is_null($arr)) return array();
		
			return is_array($arr) ? $arr : array($arr);
		
		}
		
		
		/**
		 *	Attempts to find some element in an array.
		 *
		 *	\param [in] $arr
		 *		The array.
		 *	\param [in] $what
		 *		The element.
		 *	\param [in] $throw
		 *		If \em true and \em what cannot be
		 *		found in \em arr, a NotFoundException
		 *		will be thrown, otherwise \em null
		 *		will be returned in this case.  Defaults
		 *		to \em false.
		 *	\param [in] $comparer
		 *		An optional callable object which will
		 *		be used to compare objects for equality.
		 *		Defaults to \em null.  If \em null
		 *		strict comparison will be used.
		 *
		 *	\return
		 *		The key associated with \em what in
		 *		\em arr if \em what is in \em arr,
		 *		\em null otherwise.
		 */
		public static function Find ($arr, $what, $throw=false, $comparer=null) {
		
			$arr=self::Coalesce($arr);
			
			foreach ($arr as $key=>$value) {
			
				if (is_null($comparer)
					?	($what===$value)
					:	$comparer($value,$what)
				) return $key;
			
			}
			
			if ($throw) throw new NotFoundException(
				'Value could not be found in array'
			);
			
			return null;
		
		}
	
	
		/**
		 *	Checks an array to see if it contains
		 *	some element.
		 *
		 *	\param [in] $arr
		 *		The array.
		 *	\param [in] $what
		 *		The element.
		 *	\param [in] $comparer
		 *		An optional callable object which will
		 *		be used to compare objects for equality.
		 *		Defaults to \em null.  If \em null
		 *		strict comparison will be used.
		 *
		 *	\return
		 *		\em true if \em what is in \em arr,
		 *		\em false otherwise.
		 */
		public static function In ($arr, $what, $comparer=null) {
		
			$arr=self::Coalesce($arr);
			
			if (is_null($comparer)) $comparer=function ($a, $b) {
			
				if (is_string($a)) return is_string($b) ? String::Equals($a,$b) : false;
				
				return $a===$b;
			
			};
			
			foreach ($arr as $x) if ($comparer($x,$what)) return true;
			
			return false;
		
		}
		
		
		private static function stable_sort (array $a, $sorter) {
			
			$c=count($a);
			
			if ($c<=1) return $a;
			
			$h=intval($c/2);
			return iterator_to_array(
				Iterable::Merge(
					self::stable_sort(
						array_slice($a,0,$h),
						$sorter
					),
					self::stable_sort(
						array_slice($a,$h),
						$sorter
					),
					$sorter
				)
			);
			
		}
		
		
		/**
		 *	Stably sorts an array.
		 *
		 *	Any keys associated with items in the array will be
		 *	discarded.
		 *
		 *	\param [in] $a
		 *		The array to sort.
		 *	\param [in] $sorter
		 *		A callable object which will be used to compare elements
		 *		from \em a.  Should return
		 *		a negative integer if its first argument should
		 *		precede its second argument, 0 if the two are not
		 *		ordered relative to one another, or a positive
		 *		number if its second argument should precede its
		 *		first argument.  Defaults to \em null, in which case
		 *		The less than, greater than, and equal to operators
		 *		will be used for comparison.
		 *
		 *	\return
		 *		A stably sorted version of \em a.
		 */
		public static function StableSort (array $a, $sorter=null) {
			
			if (is_null($sorter)) $sorter=function ($a, $b) {
				
				if ($a<$b) return -1;
				if ($a===$b) return 0;
				return 1;
				
			};
			
			return self::stable_sort($a,$sorter);
			
		}
	
	
	}


?>