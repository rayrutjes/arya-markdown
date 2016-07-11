<?php

namespace RayRutjes\AryaMarkdown\Test;

use Parsedown;
use RayRutjes\AryaMarkdown\AryaMarkdown;

class AryaMarkdownTest extends \PHPUnit_Framework_TestCase
{
    public function testCanBeInitializedWithAParsedownInstance()
    {
        $parser = new Parsedown();
        $plugin = new AryaMarkdown($parser);
        $this->assertSame($parser, $plugin->getParser());
    }

    public function testCanLazyLoadADefaultParsedownInstance()
    {
        $plugin = new AryaMarkdown();
        $this->assertInstanceOf(Parsedown::class, $plugin->getParser());
    }

    public function testProvidesReasonableDefaultExtensions()
    {
        $plugin = new AryaMarkdown();
        $expected = ['md', 'markdown'];
        $this->assertEquals($expected, $plugin->getExtensions());
    }

    /**
     * @dataProvider customExtensionsProvider
     */
    public function testAcceptsCustomExtensions($extensions, $expected)
    {
        $plugin = new AryaMarkdown();
        $plugin->setExtensions($extensions);
        $this->assertEquals($expected, $plugin->getExtensions());
    }

    public function customExtensionsProvider()
    {
        return [
            [['php', 'html'], ['php', 'html']],
            [['md', 99], ['md']],
            [['md', null], ['md']],
            [[], []],
        ];
    }

    /**
     * @dataProvider filenamesProvider
     */
    public function testCanDecideIfFileShouldBeConverted(array $extensions, string $filename, bool $expected)
    {
        $plugin = new AryaMarkdown();
        $plugin->setExtensions($extensions);
        $this->assertEquals($expected, $plugin->shouldConvert($filename));
    }

    public function filenamesProvider()
    {
        return [
            [['md', 'markdown'], 'index.md', true],
            [['md', 'markdown'], 'index.html', false],
            [['html', 'markdown'], 'index.html', true],
            [['md', 'html'], 'index.html', true],
            [['blade.php', 'html'], 'index.blade.php', true],
            [['blade.php', 'html'], 'index.php', false],
            [['blade.php', 'html'], 'index.twig', false],
        ];
    }

    public function testProvidesAReasonableDefaultDestinationExtension()
    {
        $plugin = new AryaMarkdown();
        $this->assertEquals('html', $plugin->getDestinationExtension());
    }

    /**
     * @dataProvider destinationFilenamesProvider
     */
    public function testCanDetermineTheDestinationFilename(array $extensions, string $destinationExtension, string $filename, string $expected)
    {
        $plugin = new AryaMarkdown();
        $plugin->setExtensions($extensions);
        $plugin->setDestinationExtension($destinationExtension);
        $this->assertEquals($expected, $plugin->toDestinationFilename($filename));
    }

    public function destinationFilenamesProvider()
    {
        return [
            [['md', 'markdown'], 'html', 'index.md', 'index.html'],
            [['md', 'markdown'], 'blade.php', 'index.md', 'index.blade.php'],
            [['html', 'markdown'], 'twig', 'index.php', 'index.php'],
            [['blade.php', 'html'], 'html', 'index.blade.php', 'index.html'],
        ];
    }
}
