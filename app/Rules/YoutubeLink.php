<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class YoutubeLink implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if it's a valid URL
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            // Check if it's a YouTube URL
            if (!$this->isYoutubeUrl($value)) {
                $fail('The :attribute must be a valid YouTube URL.');
            }
            return;
        }

        // Check if it's an embed code
        if (!$this->isEmbedCode($value)) {
            $fail('The :attribute must be a valid YouTube URL or embed code.');
        }
    }

    /**
     * Check if the input is a valid YouTube URL
     */
    private function isYoutubeUrl(string $url): bool
    {
        $patterns = [
            '/^https?:\/\/(www\.)?youtube\.com\/watch\?v=[^&]+/',
            '/^https?:\/\/(www\.)?youtu\.be\/[^&]+/',
            '/^https?:\/\/(www\.)?youtube\.com\/embed\/[^&]+/',
            '/^https?:\/\/(www\.)?m\.youtube\.com\/watch\?v=[^&]+/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the input is a valid YouTube embed code
     */
    private function isEmbedCode(string $code): bool
    {
        // Check if it contains YouTube embed iframe
        return preg_match('/src="https?:\/\/(www\.)?youtube\.com\/embed\/[^"]+"/', $code) ||
            preg_match("/src='https?:\/\/(www\.)?youtube\.com\/embed\/[^']+'/", $code);
    }

    /**
     * Extract YouTube video ID from input
     */
    public static function extractVideoId($input): ?string
    {
        $patterns = [
            // Embed format: src="https://www.youtube.com/embed/VIDEO_ID"
            '/youtube\.com\/embed\/([^"&?\/\s]{11})/',

            // Standard format: https://www.youtube.com/watch?v=VIDEO_ID
            '/youtube\.com\/watch\?v=([^"&?\/\s]{11})/',

            // Short format: https://youtu.be/VIDEO_ID
            '/youtu\.be\/([^"&?\/\s]{11})/',
        ];

        foreach ($patterns as $pattern) {
            preg_match($pattern, $input, $matches);
            if (isset($matches[1])) {
                return $matches[1];
            }
        }

        return null;
    }
}
