<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Encapsulates a range of dates and times.
	 */
	class DateTimeRange {
		
		
		/**
		 *	The start of the range.
		 */
		public $start;
		/** 
		 *	The end of the range.
		 */
		public $end;
		
		
		private function normalize () {
		
			if ($this->start->getTimestamp()>$this->end->getTimestamp()) Utility::Swap(
				$this->start,
				$this->end
			);
		
		}
		
		
		/**
		 *	Creates a new DateTimeRange object.
		 *
		 *	If \em start and \em end are not in the
		 *	proper logical order (i.e. if \em start
		 *	comes after \em end) they will be
		 *	silently swapped.
		 *
		 *	\param [in] $start
		 *		The start of the range.
		 *	\param [in] $end
		 *		The end of the range.
		 */
		public function __construct (\DateTime $start, \DateTime $end) {
		
			$this->start=$start;
			$this->end=$end;
			
			$this->normalize();
		
		}
		
		
		private function render_impl ($command, $format) {
		
			$dt=(is_null($command) || ($command==='^')) ? $this->start : $this->end;
			
			$retr=$dt->format($format);
			
			return ($retr===$format) ? ($command.$format) : $retr;
		
		}
		
		
		private function render ($format) {
		
			$retr='';
			$escape=false;
			$command=null;
			foreach (Regex::Matches('/./us',$format) as $char) {
			
				if ($escape) {
				
					$escape=false;
					$retr.=$char[0];
					
					continue;
				
				}
				
				if ($char[0]==='\\') {
				
					$escape=true;
					
					if (!is_null($command)) {
					
						$retr.=$command;
						
						$command=null;
					
					}
					
					continue;
				
				}
				
				if (
					is_null($command) &&
					(
						($char[0]==='^') ||
						($char[0]==='$')
					)
				) {
				
					$command=$char[0];
					
					continue;
				
				}
				
				$retr.=self::render_impl($command,$char[0]);
				
				$command=null;
			
			}
			
			if ($escape) $retr.='\\';
			else if (!is_null($command)) $retr.=$command;
			
			return $retr;
		
		}
		
		
		/**
		 *	Formats the range, producing a string
		 *	according to a set of rules.
		 *
		 *	The rules are specified as an associative
		 *	array.  Each key/value pair in the associative
		 *	array is regarded in order.  The key is used
		 *	as an input to the format methods of both
		 *	\em start and \em end.  If the output of
		 *	those methods are identical, processing
		 *	continues, otherwise the value associated
		 *	with that key is used to format the date
		 *	time range.
		 *
		 *	The empty string is regarded specially as
		 *	a key.  Its associated value is unconditionally
		 *	used as the format string for the range,
		 *	meaning that further key/value pairs will not
		 *	be regarded.
		 *
		 *	The format strings (i.e. the values of the
		 *	key/value pairs) follow the same format as
		 *	DateTime::format and the PHP built-in
		 *	function date, with two changes:
		 *
		 *	-	A format code which is preceded immediately
		 *		by \"^\" will produce the same substitution
		 *		as invoking the format method of \em start.
		 *	-	A format code which is preceded immediately
		 *		by \"$\" will produce the same substitution
		 *		as invoking the format method of \em end.
		 *
		 *	If a format code is not preceded by either of
		 *	these characters, it will produce the same
		 *	substitution as invoking the format method
		 *	on either \em start or \em end (which is
		 *	actually used is unspecified).
		 *
		 *	Similarly to DateTime::format and the PHP
		 *	built-in function date, the reverse solidus
		 *	may be used to \"escape\" special characters,
		 *	causing them to lose their special meaning and
		 *	be transcribed directly into the output.
		 *
		 *	Similarly to DateTime::format unrecognized
		 *	characters (i.e. those that do not have a
		 *	special meaning) will be passed through to the
		 *	output untouched.
		 *
		 *	Moreover, special characters in a context
		 *	where their special meaning is inappropriate
		 *	will be passed through to the output untouched.
		 *
		 *	If processing reaches the end of the set of
		 *	rules without finding a match, an
		 *	InvalidArgumentException will be thrown.
		 *
		 *	\param [in] $rules
		 *		The rules according to which to format
		 *		the range.
		 *
		 *	\return
		 *		A string representing this range according
		 *		to \em rules.
		 */
		public function Format ($rules=array(
			'Y' => '^F ^j^S, ^Y ^g:^i ^A - $F $j$S, $Y $g:$i $A',
			'n' => '^F ^j^S ^g:^i ^A - $F $j$S $g:$i $A, Y',
			'j' => 'F ^j^S ^g:^i ^A - $j$S $g:$i $A, Y',
			'A' => 'F jS, Y ^g:^i ^A - $g:$i $A',
			'g:i' => 'F jS, Y ^g:^i - $g:$i A',
			'' => 'F jS, Y g:i A'
		)) {
		
			$this->normalize();
			
			if (!is_array($rules)) $rules=array('' => $rules);
			
			foreach ($rules as $compare=>$format) {
			
				if (
					($compare==='') ||
					($this->start->format($compare)!==$this->end->format($compare))
				) return self::render($format);
			
			}
			
			throw new \InvalidArgumentException('Date/Time range matches no rule');
		
		}
	
	
	}


?>