<?php

namespace App\Services;

use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory as ExcelIOFactory;

class FileTextExtractor
{
    public function extractTextFromDocument($file)
    {
        // Get MIME type directly from the file object
        $mimeType = $file->getMimeType();

        // Get the file contents or a stream
        $filePath = $file->getRealPath();

        switch ($mimeType) {
            case 'application/pdf':
                $parser = new PdfParser();
                $pdf = $parser->parseFile($filePath);
                return $pdf->getText();

            case 'text/plain':
                return file_get_contents($filePath);

            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                $wordReader = WordIOFactory::createReader('Word2007');
                $phpWord = $wordReader->load($filePath);
                $text = '';
                foreach ($phpWord->getSections() as $section) {
                    $elements = $section->getElements();
                    foreach ($elements as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . "\n";
                        }
                    }
                }
                return $text;

            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                $spreadsheet = ExcelIOFactory::load($filePath);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $text = '';
                foreach ($sheetData as $row) {
                    $text .= implode("\t", $row) . "\n";
                }
                return $text;

            default:
                throw new \Exception("Unsupported MIME type: $mimeType");
        }
    }
}
