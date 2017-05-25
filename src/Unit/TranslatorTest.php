<?php

namespace qtx\Unit;

use qtx\Translator;

class TranslatorTest extends \PHPUnit\Framework\TestCase {

    /**
     * @covers \qtx\Translator::parseTags()
     */
    function testTranslatorWithoutString() {
        $t = new Translator();
        $this->expectException(\InvalidArgumentException::class);
        $t->parseTags(1);
    }
}