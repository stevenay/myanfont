<?php 

namespace SteveNay\MyanFont;

/**
 * Regular Expression Collection Base Class for 
 * Zawgyi and Unicode.
 * 
 * All the regular expressions are taken from
 * original "knayi" library as well as
 * Thant Thet "MMFontTagger" code based on Ko @ravichhabra regex.
 */
class RuleBase
{
    // [\u0009\u0020\u000D\u000A] WhiteSpace in Unicode Character
    const WHITESPACE = '[\\x20\\t\\r\\n\\f]';
    public static $ruleSet = [
        'unicode' => [
            '[ဃငဆဇဈဉညဋဌဍဎဏဒဓနဘရဝဟဠအ]်', 'ျ[က-အ]ါ', 'ျ[ါ-း]', '\u1031[^\u1000-\u1021\u103b\u1040\u106a\u106b\u107e-\u1084\u108f\u1090]',
            '\u1031$', '\u1025\u102f', '\u103c\u103d[\u1000-\u1001]', 'ျင်း', 'ျာ', 'င့်',
            '\u103e', '\u103f', '\u100a\u103a', '\u1014\u103a', '\u1031\u1038', '\u1031\u102c',
            '\u103a\u1038', '\u1035', '[\u1050-\u1059]', '^([\u1000-\u1021]\u103c|[\u1000-\u1021]\u1031)'
        ],
        'zawgyi' => [
            '\u102c\u1039', '\u103a\u102c', self::WHITESPACE . '(\u103b|\u1031|[\u107e-\u1084])[\u1000-\u1021]'
            ,'^(\u103b|\u1031|[\u107e-\u1084])[\u1000-\u1021]', '[\u1000-\u1021]\u1039[^\u1000-\u1021]', '\u1025\u1039'
            ,'\u1039\u1038' ,'[\u102b-\u1030\u1031\u103a\u1038](\u103b|[\u107e-\u1084])[\u1000-\u1021]' ,'\u1036\u102f'
            ,'[\u1000-\u1021]\u1039\u1031' , '\u1064','\u1039' . self::WHITESPACE, '\u102c\u1031'
            ,'[\u102b-\u1030\u103a\u1038]\u1031[\u1000-\u1021]', '\u1031\u1031', '\u102f\u102d', '\u1039$'
        ]
    ];
}