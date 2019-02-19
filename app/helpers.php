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

            // Boundaries. Match space + [] pair
            $start = '[\s|\[]';
            $end   = '[\s|\]]';

            // Position in the line.
            $beginning = '^' . $start . '*' . $needle . $end . '+';
            $middle    = $start . '+' . $needle . $end . '+';
            $end       = $start . '+' . $needle . $end . '*$';

            if ( ! ! preg_match('/' . $beginning . '|' . $middle . '|' . $end . '/i', $haystack)) {
                return true;
            }
        }

        return false;
    }
}