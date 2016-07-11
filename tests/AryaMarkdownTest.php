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
}
