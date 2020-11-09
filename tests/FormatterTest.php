<?php

use OutputFormat\Formats\Color;
use OutputFormat\Formats\Text\Lowercase;
use OutputFormat\Formats\Text\Ucwords;
use OutputFormat\Formats\TextFeatures;
use OutputFormat\Outputter;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    /** @var Outputter */
    protected Outputter $outputter;

    public function setUp(): void
    {
        parent::setUp();
        $this->outputter = Outputter::init();
    }

    public function testColor()
    {
        $colorFormatter = new Color();
        $this->assertIsString($colorFormatter('red'));
        $this->assertIsString($colorFormatter('blabla'));
        $this->assertIsString($colorFormatter(50));
        $this->assertIsString($colorFormatter("50"));
    }

    public function testLowercase()
    {
        $lowercase = new Lowercase();
        $this->assertEquals('test', $lowercase(null,'tEsT'));
    }

    public function testCapitalizeWords()
    {
        $ucwords = new Ucwords();
        $this->assertEquals('Testings Tests First Time', $ucwords(null,'testings tests first time'));
    }

    public function testTextFeatures()
    {
        $textFeatures = new TextFeatures();
        $this->assertEquals($textFeatures('bold'), $this->outputter->getConfig('translation-formats.text-features.bold'));
        $this->assertEquals($textFeatures('dim'), $this->outputter->getConfig('translation-formats.text-features.dim'));
        $this->assertEquals($textFeatures('underline'), $this->outputter->getConfig('translation-formats.text-features.underline'));
        $this->assertEquals($textFeatures('blink'), $this->outputter->getConfig('translation-formats.text-features.blink'));
        $this->assertEquals($textFeatures('reverse'), $this->outputter->getConfig('translation-formats.text-features.reverse'));
        $this->assertEquals($textFeatures('hidden'), $this->outputter->getConfig('translation-formats.text-features.hidden'));
    }
}