<?php

namespace App\Traits;

trait SanitizesInput
{
    protected function sanitizeInput($input)
    {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }

        if (is_string($input)) {
            // Remove NULL bytes
            $input = str_replace(chr(0), '', $input);
            
            // Convert special characters to HTML entities
            $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
            
            // Remove any potential script injection
            $input = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $input);
            
            // Remove any potential SQL injection patterns
            $input = preg_replace('/union\s+select/i', '', $input);
            
            return trim($input);
        }

        return $input;
    }

    public function validateSanitized($rules)
    {
        $sanitizedInput = $this->sanitizeInput($this->all());
        $this->replace($sanitizedInput);
        
        return $this->validate($rules);
    }
}
