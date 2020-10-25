<?php
declare(strict_types=1);


namespace BobbyAHines\JeffersonParishCodePdf;


use ErrorException;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Spatie\PdfToText\Pdf;

class FileHandler
{
    protected string $txtFilePath;

    public function __construct()
    {
        $this->txtFilePath = dirname(__DIR__, 1) . '/resources/txt/plainTxtConversion.txt';
    }

    /**
     * Save the PDF resource as a Text file.
     * @param string
     * @return bool
     */
    public function savePdfAsText(string $pdfFilePath): bool
    {
        $pdfToText = new Pdf();

        try {
            $pdfToText->setPdf($pdfFilePath);
        } catch (PdfNotFound $exception) {
            echo $exception->getMessage();
        }

        $fileContents = $pdfToText->text();
        unset($pdfToText);

        $saved = file_put_contents($this->txtFilePath, $fileContents);
        unset($fileContents);

        if (!$saved) {
            return false;
        }

        return true;
    }

    public function ReadTextFile(): ?string
    {
        try {
            $fileContents = file_get_contents($this->txtFilePath);
            if (!$fileContents) {
                throw new ErrorException('Unable to load the text file. Does it exist?');
            }
            return $fileContents;
        } catch (ErrorException $e) {
            echo $e->getMessage();
        }

        return null;
    }

    /**
     * Delete the PDF resource file.
     * @param string
     * @return bool
     */
    public function deletePdfFile(string $pdfFilePath): bool
    {
        try {
            unlink($pdfFilePath);
            if (file_exists($pdfFilePath)) {
                throw new ErrorException('Failed to delete file.');
            }
            return true;
        } catch (ErrorException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * Delete the Text resource file.
     * @param string
     * @return bool
     */
    public function deleteTextFile(string $txtFilePath): bool
    {
        try {
            unlink($txtFilePath);
            if (file_exists($this->txtFilePath)) {
                throw new ErrorException('Failed to delete file.');
            }
            return true;
        } catch (ErrorException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}