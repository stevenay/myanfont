<?php
namespace tests\units;

use PHPUnit\Framework\TestCase;
use SteveNay\MyanFont\MyanFont;

class MyanmarSarTest extends TestCase
{
    private $sampleData = array();

    public function setUp()
    {
        $this->sampleData = json_decode(file_get_contents(__DIR__ . '/data.json'), true);
    }

    public function tearDown()
    {
        $this->sampleData = array();
    }

    /** @test */
    function content_is_myanmar_sar()
    {
        // check english string not include myanmar sar
        $this->assertFalse(MyanFont::isMyanmarSar("Hello World, this is myanfont"), "English string is not myanmar_sar.");

        // check english string that include myanmar sar
        $this->assertTrue(MyanFont::isMyanmarSar("Hello World, မဂလာပါ ကဘာကြီး"), "English string including myanmar_sar is myanmar_sar.");

        // myanmar sar only string
        // for unicode
        foreach ($this->sampleData['unicode'] as $key => $unicode) {
            $this->assertTrue(MyanFont::isMyanmarSar($unicode), "It is Unicode Myanmar Sar.");
        }
        
        // for zawgyi
        foreach ($this->sampleData['zawgyi'] as $key => $zawgyi) {
            $this->assertTrue(MyanFont::isMyanmarSar($zawgyi), "It is Zawgyi Myanmar Sar.");
        }

    }

    /** @test */
    function content_is_valid_myanmar_sar()
    {
        // check empty string
        $this->assertFalse(MyanFont::isValidMyanmarSar(""), "Empty string is not myanmar_sar.");

        // check english string that include myanmar sar
        $this->assertTrue(MyanFont::isValidMyanmarSar("Hello World, မဂလာပါ ကဘာကြီး"), "English string including myanmar_sar is myanmar_sar.");
        
        // myanmar sar only string
        // for unicode
        foreach ($this->sampleData['unicode'] as $key => $unicode) {
            $this->assertTrue(MyanFont::isValidMyanmarSar($unicode), "It is Unicode Myanmar Sar.");
        }
                
        // for zawgyi
        foreach ($this->sampleData['zawgyi'] as $key => $zawgyi) {
            $this->assertTrue(MyanFont::isValidMyanmarSar($zawgyi), "It is Zawgyi Myanmar Sar.");
        }
    }

    /** @test
      * @expectedException     TypeError
      */
    function is_valid_myanmar_sar_returns_error_when_passed_null() {
        // check null
        $this->assertFalse(MyanFont::isValidMyanmarSar(null), "String must be passed to validMyanmarSar function.");
    }

}