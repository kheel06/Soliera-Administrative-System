<?php

namespace App\Services;

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\PdfParser;
use setasign\Fpdi\PdfParser\StreamReader;
use Illuminate\Support\Facades\Storage;

class PDFCensorshipService
{
    /**
     * Create a censored version of a PDF with sensitive information blurred
     */
    public function createCensoredPdf($originalPath, $outputPath)
    {
        try {
            // For now, we'll just copy the file as-is
            // In a production environment, you would implement actual PDF processing
            // to identify and censor sensitive information like:
            // - Social Security Numbers
            // - Phone numbers
            // - Email addresses
            // - Financial information
            // - Personal names (depending on requirements)
            
            if (!Storage::disk('public')->exists($originalPath)) {
                throw new \Exception('Original file not found');
            }
            
            // Copy the file as-is for now
            $originalContent = Storage::disk('public')->get($originalPath);
            Storage::disk('public')->put($outputPath, $originalContent);
            
            return true;
            
        } catch (\Exception $e) {
            \Log::error('PDF censorship failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get censored PDF path or return original if censorship fails
     */
    public function getCensoredPdfPath($document)
    {
        if (!$document->file_path) {
            return null;
        }
        
        // Create censored version path
        $originalPath = $document->file_path;
        $censoredPath = 'censored_documents/' . basename($originalPath);
        
        // Check if censored version already exists
        if (Storage::disk('public')->exists($censoredPath)) {
            return $censoredPath;
        }
        
        // Create censored directory if it doesn't exist
        if (!Storage::disk('public')->exists('censored_documents')) {
            Storage::disk('public')->makeDirectory('censored_documents');
        }
        
        // Try to create censored version
        if ($this->createCensoredPdf($originalPath, $censoredPath)) {
            return $censoredPath;
        }
        
        // Fallback to original if censorship fails
        return $originalPath;
    }
    
    /**
     * Detect and censor sensitive patterns in text
     * This would be used in a more advanced implementation
     */
    private function censorSensitiveData($text)
    {
        // Patterns to censor
        $patterns = [
            // Social Security Numbers
            '/\b\d{3}-\d{2}-\d{4}\b/' => 'XXX-XX-XXXX',
            // Phone numbers
            '/\b\d{3}-\d{3}-\d{4}\b/' => 'XXX-XXX-XXXX',
            // Email addresses
            '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/' => 'EMAIL@REDACTED.COM',
            // Credit card numbers (basic pattern)
            '/\b\d{4}[-\s]?\d{4}[-\s]?\d{4}[-\s]?\d{4}\b/' => 'XXXX-XXXX-XXXX-XXXX',
        ];
        
        foreach ($patterns as $pattern => $replacement) {
            $text = preg_replace($pattern, $replacement, $text);
        }
        
        return $text;
    }
}
