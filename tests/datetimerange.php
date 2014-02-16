<?php


	namespace Tests;
	
	
	use \CivicInfoBC\DateTimeRange as D;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class DateTimeRange extends \CivicInfoBC\Testing\TestSuite {
	
	
		public static function make ($str) {
		
			return \DateTime::createFromFormat(
				'd/m/Y G:i:s',
				$str
			);
		
		}
	
	
		public static function get () {
		
			return new D(
				self::make('1/1/2013 00:00:00'),
				self::make('1/1/2014 00:00:00')
			);
		
		}
	
	
		public function __construct () {
		
			parent::__construct('Date/Time Range');
			
			$this->tester->tests=array(
				new T(
					'Construction',
					'Start and end dates are swapped if they are not passed in the correct order',
					function () {
					
						$start=DateTimeRange::make('1/1/2013 00:00:00');
						$end=DateTimeRange::make('1/1/2014 00:00:00');
						
						$r=new D($end,$start);
						
						return ($r->start===$start) && ($r->end===$end);
					
					}
				),
				new T(
					'Format',
					'Format method preserves DateTime::format behaviour for unqualified format codes',
					function () {	return DateTimeRange::get()->Format('S')==='st';	}
				),
				new T(
					'Format',
					'"^" may be used to apply format codes only to the start of the range',
					function () {	return DateTimeRange::get()->Format('^Y')==='2013';	}
				),
				new T(
					'Format',
					'"$" may be used to apply format codes only to the end of the range',
					function () {	return DateTimeRange::get()->Format('$Y')==='2014';	}
				),
				new T(
					'Format',
					'Rules may be specified to conditionally select a certain formatting',
					function () {
					
						$rules=array(
							'Y' => '^Y$Y',
							'' => 'Y'
						);
						
						$r=DateTimeRange::get();
						
						if ($r->Format($rules)!=='20132014') return false;
						
						$r->end=$r->start;
						
						return $r->Format($rules)==='2013';
					
					}
				),
				new T(
					'Format (swapping)',
					'If the start and end dates are out of order when Format is invoked, they are swapped',
					function () {
					
						$r=DateTimeRange::get();
						\CivicInfoBC\Utility::Swap($r->start,$r->end);
						if ($r->start->getTimestamp()<=$r->end->getTimestamp()) return false;
						return $r->Format('^Y')==='2013';
					
					}
				)
			);
		
		}
	
	
	}


?>