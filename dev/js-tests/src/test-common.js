CommonTestCase = TestCase("CommonTestCase");

CommonTestCase.prototype.testSplit = function () {
    var text   = "<!--:en-->English Text<!--:--><!--:de-->Deutscher Text<!--:-->";
    var result = qtranxj_split(text);
    assertEquals(result.en, 'English Text');
    assertEquals(result.de, 'Deutscher Text');

    var text2 = "[:en]English Text[:de]Deutscher Text[:]";
    var result2 = qtranxj_split(text2);
    assertEquals(result2.en, 'English Text');
    assertEquals(result2.de, 'Deutscher Text');

    var text3 = "{:en}English Text{:de}Deutscher Text{:}";
    var result3 = qtranxj_split(text3);
    assertEquals(result3.en, 'English Text');
    assertEquals(result3.de, 'Deutscher Text');
};
