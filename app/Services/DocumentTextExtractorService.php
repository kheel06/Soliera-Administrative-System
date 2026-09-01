<?php

namespace App\Services;

class DocumentTextExtractorService
{
    public function extractText($filePath)
    {
        $extension = $this->detectActualFileExtension($filePath);
        $text = "";
        $method = "unknown";

        // Log the start of extraction
        \Log::info('DocumentTextExtractor: Starting text extraction', [
            'file_path' => $filePath,
            'detected_extension' => $extension,
            'file_exists' => file_exists($filePath),
            'file_size' => file_exists($filePath) ? filesize($filePath) : 'N/A'
        ]);

        switch (strtolower($extension)) {
            case 'txt':
                $text = $this->extractFromTxt($filePath);
                $method = "txt_read";
                break;
            case 'pdf':
                $text = $this->extractFromPdf($filePath);
                $method = "pdf_parser"; // This will be refined inside extractFromPdf
                break;
            case 'doc':
            case 'docx':
                $text = $this->extractFromWord($filePath);
                $method = "phpword";
                break;
            case 'xls':
            case 'xlsx':
                $text = $this->extractFromSpreadsheet($filePath);
                $method = "spreadsheet";
                break;
            case 'ppt':
            case 'pptx':
                $text = $this->extractFromPresentation($filePath);
                $method = "presentation_placeholder";
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
                $text = $this->extractFromImage($filePath);
                $method = "tesseract_ocr";
                break;
            default:
                \Log::warning('DocumentTextExtractor: Unknown document type, returning empty text', [
                    'file_path' => $filePath,
                    'extension' => $extension
                ]);
                $text = ""; // No extraction for unknown types
                $method = "unsupported_type";
                break;
        }

        $quality = $this->validateExtraction($text);

        \Log::info('DocumentTextExtractor: Extraction completed with quality assessment', [
            'file_path' => $filePath,
            'extracted_method' => $method,
            'text_length' => strlen($text),
            'quality_score' => $quality['reliability_score'],
            'is_valid' => $quality['is_valid'],
            'text_preview' => substr($text, 0, 200)
        ]);

        return [
            'text' => $text,
            'quality' => $quality,
            'method' => $method,
            'extension' => $extension,
            'is_valid' => $quality['reliability_score'] > 0.3
        ];
    }

    private function validateExtraction($text)
    {
        if (empty(trim($text))) {
            return [
                'reliability_score' => 0,
                'word_count' => 0,
                'char_count' => 0,
                'keyword_density' => 0,
                'is_valid' => false
            ];
        }

        $charCount = strlen($text);
        $wordCount = str_word_count($text);

        // Check for common legal keywords to verify it's a real document
        $keywords = ['WHEREAS', 'AGREEMENT', 'CONTRACT', 'TERMS', 'CONDITIONS', 'PARTIES', 'WITNESS', 'REPUBLIC', 'LAW'];
        $foundKeywords = 0;
        $upperText = strtoupper($text);
        foreach ($keywords as $kw) {
            if (strpos($upperText, $kw) !== false)
                $foundKeywords++;
        }

        $keywordDensity = count($keywords) > 0 ? $foundKeywords / count($keywords) : 0;

        // Scoring Logic:
        // Length (40%) + Keyword Presence (60%)
        $lengthScore = min(1, $wordCount / 200); // Expecting at least 200 words for a good contract
        $reliabilityScore = ($lengthScore * 0.4) + ($keywordDensity * 0.6);

        return [
            'reliability_score' => round($reliabilityScore, 2),
            'word_count' => $wordCount,
            'char_count' => $charCount,
            'keyword_density' => round($keywordDensity, 2),
            'is_valid' => $reliabilityScore > 0.3
        ];
    }

    private function extractFromTxt($filePath)
    {
        if (!file_exists($filePath)) {
            \Log::error('DocumentTextExtractor: Text file not found', ['file_path' => $filePath]);
            return "";
        }

        $content = file_get_contents($filePath);
        return $this->sanitizeText($content ?: "");
    }

    private function extractFromPdf($filePath)
    {
        $text = "";

        // Method 1: Try Smalot PDF Parser
        try {
            if (class_exists(\Smalot\PdfParser\Parser::class)) {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($filePath);
                $text = trim($pdf->getText());
                if ($text !== '' && strlen($text) > 50) {
                    return $this->sanitizeText($text);
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('DocumentTextExtractor: Smalot parser failed for PDF', ['error' => $e->getMessage(), 'file_path' => $filePath]);
        }

        // Method 2: Try pdftotext (poppler-utils)
        try {
            $pdftotext = $this->getExecutablePath('pdftotext');
            if (!empty($pdftotext)) {
                // Try with layout preservation first
                $cmd = escapeshellarg($pdftotext) . ' -layout -nopgbrk ' . escapeshellarg($filePath) . ' -';
                $out = @shell_exec($cmd);
                $out = is_string($out) ? trim($out) : '';

                if ($out !== '' && strlen($out) > 50) {
                    return $this->sanitizeText($out);
                }

                // Try without layout if layout failed
                $cmd = escapeshellarg($pdftotext) . ' ' . escapeshellarg($filePath) . ' -';
                $out = @shell_exec($cmd);
                $out = is_string($out) ? trim($out) : '';

                if ($out !== '' && strlen($out) > 50) {
                    return $this->sanitizeText($out);
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('DocumentTextExtractor: pdftotext failed for PDF', ['error' => $e->getMessage(), 'file_path' => $filePath]);
        }

        \Log::warning('DocumentTextExtractor: All PDF text extraction methods failed to yield sufficient text', ['file_path' => $filePath]);
        return "";
    }

    private function extractFromWord($filePath)
    {
        $text = "";
        try {
            // Handle only DOCX reliably; DOC is legacy and often unsupported
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            if ($extension === 'docx' && class_exists(\PhpOffice\PhpWord\IOFactory::class)) {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);

                // Extract text from all sections and elements
                foreach ($phpWord->getSections() as $section) {
                    $elements = $section->getElements();
                    foreach ($elements as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . " \n";
                        } elseif (method_exists($element, 'getElements')) {
                            // Handle nested elements (like tables)
                            foreach ($element->getElements() as $nestedElement) {
                                if (method_exists($nestedElement, 'getText')) {
                                    $text .= $nestedElement->getText() . " ";
                                }
                            }
                            $text .= "\n";
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('DocumentTextExtractor: PhpWord extraction failed', ['error' => $e->getMessage(), 'file_path' => $filePath]);
        }

        return $this->sanitizeText($text);
    }

    private function extractFromImage($filePath)
    {
        $text = "";

        // Attempt OCR via system tesseract if available
        try {
            $tesseract = $this->getExecutablePath('tesseract');

            if (!empty($tesseract)) {
                // Try different PSM modes for better OCR results
                $psmModes = [6, 8, 3]; // 6=uniform block, 8=single word, 3=fully automatic
                $bestResult = '';

                foreach ($psmModes as $psm) {
                    $cmd = escapeshellarg($tesseract) . ' ' . escapeshellarg($filePath) . ' stdout -l eng --psm ' . $psm;
                    $ocr = @shell_exec($cmd);
                    $ocr = is_string($ocr) ? trim($ocr) : '';

                    if ($ocr !== '' && strlen($ocr) > strlen($bestResult)) {
                        $bestResult = $ocr;
                    }
                }
                $text = $bestResult;
            }
        } catch (\Throwable $e) {
            \Log::warning('DocumentTextExtractor: Image OCR failed', ['error' => $e->getMessage(), 'file_path' => $filePath]);
        }

        return $this->sanitizeText($text);
    }

    private function extractFromSpreadsheet($filePath)
    {
        $text = "";
        try {
            if (class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
                foreach ($spreadsheet->getAllSheets() as $sheet) {
                    $rows = $sheet->toArray(null, true, true, true);
                    foreach ($rows as $row) {
                        $line = array_filter(array_map('trim', array_values($row)), function ($v) {
                            return $v !== null && $v !== ''; });
                        if (!empty($line)) {
                            $text .= implode(' | ', $line) . "\n";
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('DocumentTextExtractor: Spreadsheet extraction failed', ['error' => $e->getMessage(), 'file_path' => $filePath]);
        }

        return $this->sanitizeText($text);
    }

    private function extractFromPresentation($filePath)
    {
        // PHPPresentation is not installed; provide descriptive placeholder
        \Log::warning('DocumentTextExtractor: Presentation file detected, but extraction not implemented.', ['file_path' => $filePath]);
        return "";
    }

    /**
     * Cross-platform executable resolver.
     * Tries common Windows paths, then Windows 'where', then Linux 'which'.
     */
    private function getExecutablePath($binary)
    {
        // Common Windows paths for Poppler and Tesseract
        $windowsCommonPaths = [
            'C:\\Program Files\\poppler\\bin\\' . $binary . '.exe',
            'C:\\Program Files (x86)\\poppler\\bin\\' . $binary . '.exe',
            'C:\\Program Files\\Tesseract-OCR\\' . $binary . '.exe',
            'C:\\Program Files (x86)\\Tesseract-OCR\\' . $binary . '.exe',
        ];

        if (stripos(PHP_OS_FAMILY, 'Windows') !== false) {
            // 1) Check common install paths
            foreach ($windowsCommonPaths as $path) {
                if (file_exists($path)) {
                    return $path;
                }
            }

            // 2) Windows: use 'where'
            try {
                $out = @shell_exec('where ' . escapeshellarg($binary) . ' 2>nul');
                if (is_string($out)) {
                    $lines = array_filter(array_map('trim', preg_split('/\r?\n/', $out)));
                    if (!empty($lines)) {
                        $candidate = reset($lines);
                        if (file_exists($candidate)) {
                            return $candidate;
                        }
                    }
                }
            } catch (\Throwable $e) {
                \Log::warning('DocumentTextExtractor: where command failed for ' . $binary, ['error' => $e->getMessage()]);
            }

            return null;
        }

        // 3) POSIX: use 'which'
        try {
            $out = @shell_exec('which ' . escapeshellarg($binary) . ' 2>/dev/null');
            $out = is_string($out) ? trim($out) : '';
            if ($out !== '') {
                return $out;
            }
        } catch (\Throwable $e) {
            \Log::warning('DocumentTextExtractor: which command failed for ' . $binary, ['error' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * Test method to verify file extension detection
     */
    public function testFileExtensionDetection($filePath)
    {
        $extension = $this->detectActualFileExtension($filePath);

        \Log::info('DocumentTextExtractor: File extension detection test', [
            'file_path' => $filePath,
            'detected_extension' => $extension
        ]);

        return $extension;
    }

    /**
     * Detect actual file extension from file content and MIME type
     */
    private function detectActualFileExtension($filePath)
    {
        // First try to get MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        // Map MIME types to extensions
        $mimeToExtension = [
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'text/plain' => 'txt',
            'image/jpeg' => 'jpg',
            'image/png' => 'png'
        ];

        if (isset($mimeToExtension[$mimeType])) {
            return $mimeToExtension[$mimeType];
        }

        // Fallback: use pathinfo
        return pathinfo($filePath, PATHINFO_EXTENSION);
    }

    /**
     * Sanitize text to handle UTF-8 encoding issues
     */
    private function sanitizeText($text)
    {
        if (empty($text)) {
            return "";
        }

        // Convert to UTF-8, ignoring invalid sequences
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

        // Remove any remaining control characters (except common whitespace like tab, newline, carriage return)
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $text);

        return trim($text);
    }
}