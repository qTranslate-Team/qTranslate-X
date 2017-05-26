<?php

namespace qtx;

class Translator {
    function translate($lang, $text) {
        try {
            $this->parseTags($text);
        } catch (\Exception $e) {

        }
    }

    function parseTags($text) {
        if (!is_string($text)) {
            throw new \InvalidArgumentException(__METHOD__ . ' expects string.');
        }
        $split_regex = "#(<!--:[a-z]{2}-->|<!--:-->|\[:[a-z]{2}\]|\[:\]|\{:[a-z]{2}\}|\{:\})#ism";
        return preg_split($split_regex, $text, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
    }
}