<?php

use PHPUnit\Framework\TestCase;
use SteveNay\MyanFont\MyanFont;

class DetectMLTest extends TestCase
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
    function detect_zawgyi_font_with_machine_learning()
    {
        // check zawgyi return
        foreach ($this->sampleData['zawgyi'] as $key => $zawgyi) {
            $this->assertSame('zawgyi', MyanFont::fontDetect($zawgyi), "Unexpected: " . $zawgyi);
            $this->assertSame('zawgyi', MyanFont::fontDetectByMachineLearning($zawgyi), "Unexpected Machine Learning (Deprecated soon): " . $zawgyi);
        }
    }

    /** @test */
    function detect_unicode_font_with_machine_learning()
    {
        // check unicode return
        foreach ($this->sampleData['unicode'] as $key => $unicode) {
            $this->assertSame('unicode', MyanFont::fontDetect($unicode), "Unexpected: " . $unicode);
            $this->assertSame('unicode', MyanFont::fontDetectByMachineLearning($unicode), "Unexpected Machine Learning (Deprecated): " . $unicode);
        }
    }
}