<?php
if ( ! function_exists('str_contains_word')) {
    /**
     * Determine if a given string contains the exact word.
     *
     * @param  string $haystack
     * @param  string|array $needles
     *
     * @return bool
     */
    function str_contains_word($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            $needle = preg_quote($needle, '/');

            if ( ! ! preg_match('/\b' . $needle . '\b/i', $haystack)) {
                return true;
            }
        }

        return false;
    }
}