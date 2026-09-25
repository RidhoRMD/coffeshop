<?php

namespace App\Services;

class ProfanityFilter
{
    protected static array $leetMap = [
        '0' => 'o',
        '1' => 'i',
        '3' => 'e',
        '4' => 'a',
        '5' => 's',
        '7' => 't',
        '@' => 'a',
        '$' => 's',
    ];

    public static function normalize(string $text): string
    {
        $text = strtolower($text);
        $text = strtr($text, self::$leetMap);
        $text = preg_replace('/[^a-z0-9\s]/', '', $text);
        $text = preg_replace('/\s+/', '', $text);

        return $text;
    }

    public static function containsBadWord(string $text): bool
    {
        $normalized = self::normalize($text);

        if ($normalized === '') {
            return false;
        }

        foreach (config('bad_words.list', []) as $word) {
            $normalizedWord = self::normalize($word);

            if ($normalizedWord !== '' && str_contains($normalized, $normalizedWord)) {
                return true;
            }
        }

        return false;
    }
}