<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for working with iterable
	 *	objects.
	 */
	class Iterable {
		
		
		/**
		 *	Retrieves an iterator for an iterable object.
		 *
		 *	\param [in] $iterable
		 *		An iterable object.
		 *
		 *	\return
		 *		An iterator which traverses \em iterable.
		 */
		public static function ToIterator ($iterable) {
			
			if (is_array($iterable)) return new \ArrayIterator($iterable);
			
			if ($iterable instanceof \IteratorAggregate) return $iterable->getIterator();
			
			return $iterable;
			
		}
		
		
		/**
		 *	Merges the sorted ranges traversed by \em a and
		 *	\em b into an object which traverses the merged,
		 *	sorted range.
		 *
		 *	If two objects compare equal, the one from \em a
		 *	will be returned before the one from \em b.
		 *
		 *	\param [in] $a
		 *		An iterable object.
		 *	\param [in] $b
		 *		An iterable object.
		 *	\param [in] $sorter
		 *		A callable object which will be used to compare
		 *		objects from \em a and \em b.  Should return
		 *		a negative integer if its first argument should
		 *		precede its second argument, 0 if the two are not
		 *		ordered relative to one another, or a positive
		 *		number if its second argument should precede its
		 *		first argument.  Defaults to \em null, in which case
		 *		The less than, greater than, and equal to operators
		 *		will be used for comparison.
		 *
		 *	\return
		 *		An object which traverses a sorted range formed
		 *		by merging \em a and \em b according to the ordering
		 *		defined by \em sorter.
		 */
		public static function Merge ($a, $b, $sorter=null) {
			
			if (is_null($sorter)) $sorter=function ($a, $b) {
				
				if ($a<$b) return -1;
				if ($a===$b) return 0;
				return 1;
				
			};
			
			$a=self::ToIterator($a);
			$a->rewind();
			$b=self::ToIterator($b);
			$b->rewind();
			
			while ($a->valid() && $b->valid()) {
				
				$ac=$a->current();
				$bc=$b->current();
				$c=$sorter($ac,$bc);
				if ($c<=0) {
					
					yield $ac;
					$a->next();
					
				} else {
					
					yield $bc;
					$b->next();
					
				}
				
			}
			
			while ($a->valid()) {
				
				yield $a->current();
				$a->next();
				
			}
			
			while ($b->valid()) {
				
				yield $b->current();
				$b->next();
				
			}
			
		}
		
		
		/**
		 *	Combines several traversable objects into one range.
		 *
		 *	Takes any number of arguments, which must all be traversable.
		 *
		 *	\return
		 *		A Traversable which traverses the ranges of all arguments,
		 *		in the order in which they were passed.
		 */
		public static function Combine () {
			
			foreach (func_get_args() as $arg) foreach ($arg as $x) yield $x;
			
		}
		
		
	}


?>