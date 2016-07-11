<?php

namespace RayRutjes\AryaMarkdown;

use Parsedown;
use RayRutjes\Arya\Arya;
use RayRutjes\Arya\Plugin;

class AryaMarkdown implements Plugin
{
    /**
     * @var Parsedown
     */
    private $parser;

    /**
     * @var array
     */
    private $extensions = ['md', 'markdown'];

    /**
     * @param Parsedown $parser
     */
    public function __construct(Parsedown $parser = null)
    {
        $this->parser = $parser ?? new Parsedown();
    }

    /**
     * @return Parsedown
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * @return array
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * @param array $extensions
     */
    public function setExtensions(array $extensions)
    {
        $this->extensions = array_filter($extensions, 'is_string');
    }

    /**
     * @param array $files
     * @param Arya  $arya
     *
     * @return array
     */
    public function __invoke(array $files, Arya $arya)
    {
        // TODO: Implement __invoke() method.
    }
}
