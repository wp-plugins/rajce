<?php

namespace WPFW\Utils;


class Strings
{
    /**
     * Converts to web safe characters [a-z0-9-] text
     * @param  string  UTF-8 encoding
     * @param  string  allowed characters
     * @param  bool
     * @return string
     */
    public static function webalize($s, $charlist = NULL, $lower = TRUE)
    {
        $s = self::toAscii($s);
        if ($lower) {
            $s = strtolower($s);
        }
        $s = preg_replace('#[^a-z0-9' . preg_quote($charlist, '#') . ']+#i', '-', $s);
        $s = trim($s, '-');
        return $s;
    }

}