<?php
declare(strict_types=1);


namespace BobbyAHines\JeffersonParishCodePdf;


class Export
{
    public string $fullText;

    /**
     * Export constructor.
     * @param string $fileContents
     */
    public function __construct(string $fileContents)
    {
        $this->fullText = $fileContents;
    }
}