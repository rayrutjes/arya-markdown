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
     * @var string
     */
    private $destinationExtension = 'html';

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
        $parsed = [];
        foreach ($files as $filename => $data) {
            if (!$this->shouldConvert($filename)) {
                $parsed[$filename] = $data;
                continue;
            }

            $data['content'] = $this->parser->parse($data['content']);
            $destinationFilename = $this->toDestinationFilename($filename);
            $parsed[$destinationFilename] = $data;
        }

        return $parsed;
    }

    /**
     * @param string $extension
     */
    public function setDestinationExtension(string $extension)
    {
        $this->destinationExtension = $extension;
    }

    /**
     * @return string
     */
    public function getDestinationExtension()
    {
        return $this->destinationExtension;
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    public function toDestinationFilename(string $filename)
    {
        $filenameLength = strlen($filename);
        foreach ($this->extensions as $extension) {
            $extLength = strlen($extension);
            $suffixLength = $filenameLength - $extLength;
            $substring = substr($filename, $suffixLength);

            if ($substring === $extension) {
                $basename = substr($filename, 0, $filenameLength - $extLength);

                return $basename.$this->destinationExtension;
            }
        }

        return $filename;
    }

    /**
     * @param string $filename
     *
     * @return bool
     */
    public function shouldConvert(string $filename)
    {
        $filenameLength = strlen($filename);
        foreach ($this->extensions as $extension) {
            $extLength = strlen($extension);
            $suffixLength = $filenameLength - $extLength;
            $substring = substr($filename, $suffixLength);

            if ($substring === $extension) {
                return true;
            }
        }

        return false;
    }
}
