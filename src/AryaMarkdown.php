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
