<?php


	abstract class TestBase extends PHPUnit_Framework_TestCase {
		
		
		protected static function GetEvent ($obj=null, $deps=array()) {
			
			return new \CivicInfoBC\Registrations\FormBuilder\Mocks\Event(
				new \CivicInfoBC\Registrations\FormBuilder\ClassModuleLoader($deps),
				is_null($obj) ? new \stdClass() : $obj
			);
			
		}
		
		
		protected static function GetUser () {
			
			return new \CivicInfoBC\Registrations\FormBuilder\Mocks\User();
			
		}
		
		
		protected static function GetDelegate () {
			
			return self::GetEvent()->CreateDelegate();
			
		}
		
		
		protected static function GetRequest () {
			
			return new \CivicInfoBC\Framework\MockRequest();
			
		}
		
		
		protected static function GetTemplateFactory () {
			
			return new \CivicInfoBC\Registrations\FormBuilder\Mocks\TemplateFactory();
			
		}
		
		
		protected static function GetConfirmationDataExtractor (\CivicInfoBC\Registrations\FormBuilder\Delegate $d=null) {
			
			return new \CivicInfoBC\Registrations\FormBuilder\ConfirmationDataExtractor(is_null($d) ? self::GetDelegate() : $d);
			
		}
		
		
		private static function throws_impl ($callable, $type) {
			
			try {
			
				$callable();
			
			} catch (\Exception $e) {
				
				return $e instanceof $type;
				
			}
			
			return false;
			
		}
		
		
		protected function assertThrows ($callable, $type='\\Exception') {
			
			$this->assertTrue(self::throws_impl($callable,$type));
			
		}
		
		
		private static function does_not_throw_impl ($callable) {
			
			try {
				
				$callable();
				
			} catch (\Exception $e) {
				
				return false;
				
			}
			
			return true;
			
		}
		
		
		protected function assertDoesNotThrow ($callable) {
			
			$this->assertTrue(self::does_not_throw_impl($callable));
			
		}
		
		
		private static function exception_matches_predicate ($callable, $pred) {
			
			try {
				
				$callable();
				
			} catch (\Exception $e) {
				
				return $pred($e);
				
			}
			
			return false;
			
		}
		
		
		protected function assertThrownExceptionMatchesPredicate ($callable, $pred) {
			
			$this->assertTrue(self::exception_matches_predicate($callable,$pred));
			
		}
		
		
		private static function invalid_delegate_names () {
			
			yield null;
			
			yield 4;
			
		}
		
		
		protected static function InvalidDelegateNames () {
			
			$d=self::GetDelegate();
			
			//	Both first and last name invalid
			foreach (self::invalid_delegate_names() as $f) foreach (self::invalid_delegate_names() as $l) {
				
				$d->first_name=$f;
				$d->last_name=$l;
				yield $d;
				
			}
			
			//	Last name invalid
			$d->first_name='a';
			foreach (self::invalid_delegate_names() as $l) {
				
				$d->last_name=$l;
				yield $d;
				
			}
			
			//	First name invalid
			$d->last_name='b';
			foreach (self::invalid_delegate_names() as $f) {
				
				$d->first_name=$f;
				yield $d;
				
			}
			
		}
		
		
		private static function get_iterator ($t) {
			
			if (is_array($t)) return new \ArrayIterator($t);
			
			while ($t instanceof \IteratorAggregate) $t=$t->getIterator();
			
			return $t;
			
		}
		
		
		protected function assertTraversable ($t, array $arr) {
			
			$i=self::get_iterator($t);
			$i->rewind();
			
			foreach ($arr as $a) {
				
				$this->assertTrue($i->valid());
				$this->assertEquals($a,$i->current());
				$i->next();
				
			}
			
			$this->assertFalse($i->valid());
			
		}
		
		
	}


?>