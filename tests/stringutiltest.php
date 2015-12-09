<?php


	use \CivicInfoBC\StringUtil as S;
	
	
	class StringUtilTest extends TestBase {
		
		
		public function testCharacters () {
			
			$this->assertTraversable(S::Characters('foo'),array(ord('f'),ord('o'),ord('o')));
			$this->assertTraversable(S::Characters('𝄞'),array(0xF0,0x9D,0x84,0x9E));
			$this->assertTraversable(S::Characters(''),array());
			
		}
		
		
		public function testCodePoints () {
			
			$this->assertTraversable(S::CodePoints('𝄞'),array(0x1D11E));
			$this->assertTraversable(S::CodePoints(''),array());
			
		}
		
		
		public function testCharacter () {
			
			$this->assertEquals('a',S::Character(0x61));
			$this->assertEquals('€',S::Character(0x20AC));
			
		}
		
		
		public function testToCaseFold () {
			
			$this->assertEquals('foo',S::ToCaseFold('FOO'));
			$this->assertEquals('einbahnstrasse',S::ToCaseFold('Einbahnstraße'));
			
		}
		
		
		public function testToUpper () {
			
			$this->assertEquals('FOO',S::ToUpper('foo'));
			
		}
		
		
		public function testToLower () {
			
			$this->assertEquals('ὀδυσσεύς',S::ToLower('ὈΔΥΣΣΕΎΣ'));
			
		}
		
		
		public function testToTitle () {
			
			$this->assertEquals('Foo Bar',S::ToTitle('foo bar'));
			
		}
		
		
		public function testNormalize () {
			
			$this->assertEquals('baz',S::Normalize('baz'));
			
			//	This string contains:
			//
			//	-	LATIN CAPITAL LETTER A WITH ACUTE (U+00C1)
			$nfc='Á';
			//	This string contains:
			//
			//	-	LATIN CAPITAL LETTER A (U+0041)
			//	-	COMBINING ACUTE ACCENT (U+0301)
			$nfd='Á';
			
			$this->assertEquals($nfc,S::Normalize($nfd,\Normalizer::FORM_C));
			$this->assertEquals($nfc,S::Normalize($nfd));
			$this->assertEquals($nfd,S::Normalize($nfc,\Normalizer::FORM_D));
			
		}
		
		
		public function testEquals () {
			
			$this->assertTrue(S::Equals('a','a'));
			
			//	This string contains:
			//
			//	-	LATIN CAPITAL LETTER A WITH ACUTE (U+00C1)
			$nfc='Á';
			//	This string contains:
			//
			//	-	LATIN CAPITAL LETTER A (U+0041)
			//	-	COMBINING ACUTE ACCENT (U+0301)
			$nfd='Á';
			
			$this->assertTrue(S::Equals($nfc,$nfd));
			
			$sharp_s='Einbahnstraße';
			$lower='einbahnstrasse';
			
			$this->assertFalse(S::Equals($sharp_s,$lower));
			$this->assertTrue(S::Equals($sharp_s,$lower,true));
			
		}
		
		
		public function testGetComparer () {
			
			$cs=S::GetComparer();
			
			$this->assertTrue($cs('a','a'));
			
			//	This string contains:
			//
			//	-	LATIN CAPITAL LETTER A WITH ACUTE (U+00C1)
			$nfc='Á';
			//	This string contains:
			//
			//	-	LATIN CAPITAL LETTER A (U+0041)
			//	-	COMBINING ACUTE ACCENT (U+0301)
			$nfd='Á';
			
			$this->assertTrue($cs($nfc,$nfd));
			
			$sharp_s='Einbahnstraße';
			$lower='einbahnstrasse';
			
			$this->assertFalse($cs($sharp_s,$lower));
			$ci=S::GetComparer(true);
			$this->assertTrue($ci($sharp_s,$lower,true));
			
		}
		
		
		public function testLength () {
			
			$this->assertEquals(0,S::Length(''));
			$this->assertEquals(1,S::Length('a'));
			$this->assertEquals(1,S::Length('€'));
			//	This string contains:
			//
			//	-	LATIN CAPITAL LETTER A (U+0041)
			//	-	COMBINING ACUTE ACCENT (U+0301)
			//
			//	So two code points
			$this->assertEquals(2,S::Length('Á'));
			
		}
		
		
		public function testCompare () {
			
			$this->assertGreaterThan(0,S::Compare('A','a'));
			$this->assertLessThan(0,S::Compare('a','A'));
			$this->assertLessThan(0,S::Compare('A','b'));
			$this->assertLessThan(0,S::Compare('a','B'));
			$this->assertLessThan(0,S::Compare('a','b'));
			$this->assertEquals(0,S::Compare('a','a'));
			
		}
		
		
		public function testGreater () {
			
			$this->assertTrue(S::Greater('A','a'));
			$this->assertTrue(S::Greater('b','a'));
			$this->assertFalse(S::Greater('a','b'));
			$this->assertFalse(S::Greater('a','a'));
			
		}
		
		
		public function testLess () {
			
			$this->assertFalse(S::Less('A','a'));
			$this->assertFalse(S::Less('b','a'));
			$this->assertTrue(S::Less('a','b'));
			$this->assertFalse(S::Less('a','a'));
			
		}
		
		
		public function testOrderedSame () {
			
			$this->assertTrue(S::OrderedSame('a','a'));
			$this->assertFalse(S::OrderedSame('a','b'));
			$this->assertFalse(S::OrderedSame('b','a'));
			
		}
		
		
		public function testGreaterOrEquals () {
			
			$this->assertTrue(S::GreaterOrEquals('A','a'));
			$this->assertTrue(S::GreaterOrEquals('b','a'));
			$this->assertFalse(S::GreaterOrEquals('a','b'));
			$this->assertTrue(S::GreaterOrEquals('a','a'));
			
		}
		
		
		public function testLessOrEquals () {
			
			$this->assertFalse(S::LessOrEquals('A','a'));
			$this->assertFalse(S::LessOrEquals('b','a'));
			$this->assertTrue(S::LessOrEquals('a','b'));
			$this->assertTrue(S::LessOrEquals('a','a'));
			
		}
		
		
		public function testGetSorter () {
			
			$asc=S::GetSorter();
			$desc=S::GetSorter(false);
			
			$this->assertLessThan(0,$asc('a','A'));
			$this->assertGreaterThan(0,$asc('A','a'));
			$this->assertGreaterThan(0,$desc('a','A'));
			$this->assertLessThan(0,$desc('A','a'));
			$this->assertEquals(0,$asc('a','a'));
			$this->assertEquals(0,$desc('a','a'));
			
		}
		
		
		public function testTrim () {
			
			$this->assertEquals('',S::Trim(''));
			$this->assertEquals('',S::Trim('      '));
			$this->assertEquals('a',S::Trim('   a'));
			$this->assertEquals('a',S::Trim('a    '));
			$this->assertEquals('a',S::Trim(' a '));
			//	This string contains PARAGRAPH SEPARATOR (U+2029)
			$ps=' ';
			$this->assertEquals('',S::Trim($ps));
			
		}
		
		
		public function testConvert () {
			
			$utf16=chr(0xD8).chr(0x34).chr(0xDD).chr(0x1E);
			$utf32=chr(0).chr(1).chr(0xD1).chr(0x1E);
			
			$this->assertEquals($utf16,S::Convert($utf32,'UTF-16BE','UTF-32BE'));
			$this->assertEquals($utf32,S::Convert($utf16,'UTF-32BE','UTF-16BE'));
			$this->assertEquals($utf16,S::Convert($utf16,'UTF-16BE','UTF-16BE'));
			
			//	Invalid UTF-32
			$this->assertThrows(function () {	S::Convert(chr(0),'UTF-8','UTF-32BE');	});
			
		}
		
		
		public function testConvertTo () {
			
			//	String contains MUSICAL SYMBOL G CLEF (U+1D11E)
			$g='𝄞';
			$utf16=chr(0xD8).chr(0x34).chr(0xDD).chr(0x1E);
			$this->assertEquals($utf16,S::ConvertTo($g,'UTF-16BE'));
			
		}
		
		
		public function testConvertFrom () {
			
			//	String contains MUSICAL SYMBOL G CLEF (U+1D11E)
			$g='𝄞';
			$utf16=chr(0xD8).chr(0x34).chr(0xDD).chr(0x1E);
			$this->assertEquals($g,S::ConvertFrom($utf16,'UTF-16BE'));
			
		}
		
		
	}


?>