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
}
