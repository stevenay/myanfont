<?php
namespace tests\units;

use PHPUnit\Framework\TestCase;
use SteveNay\MyanFont\MyanFont;

class DetectConvertTest extends TestCase
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
    function detect_zawgyi_font()
    {
         // check zawgyi return
        foreach ($this->sampleData['zawgyi'] as $key => $zawgyi) {
            $this->assertSame('zawgyi', MyanFont::fontDetectByRegularExpression($zawgyi), "Unexpected: " . $zawgyi);
        }
    }

    /** @test */
    function detect_unicode_font()
    {
         // check unicode return
        foreach ($this->sampleData['unicode'] as $key => $unicode) {
            $this->assertSame('unicode', MyanFont::fontDetectByRegularExpression($unicode), "Unexpected: " . $unicode);
        }
    }

    /** @test */
    function convert_zawgyi_to_unicode()
    {
        foreach ($this->sampleData['zawgyi'] as $key => $zawgyi) {
            $unicode = $this->sampleData['unicode'][$key];
            $this->assertSame($unicode, MyanFont::zg2uni($zawgyi));
        }
    }

    /** @test */
    function convert_unicode_to_zawgyi()
    {
        foreach ($this->sampleData['unicode'] as $key => $unicode) {
            $zawgyi = $this->sampleData['zawgyi'][$key];
            $this->assertSame($zawgyi, MyanFont::uni2zg($unicode));
        }
    }
}