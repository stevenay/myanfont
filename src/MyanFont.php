<?php 

namespace MyanFont;

use MyanFont\RuleBase;

/**
 * Detects Zawgyi or Unicode from String.
 * Can also test the input String is valid Myanmar Sar.
 * Zawgyi <=> Unicode converter also supported by wrapping Rabbit Converter.
 * 
 * This code is partially referenced from awesome 
 * https://github.com/greenlikeorange/knayi-myscript
 * javascript library.
 * 
 */
class MyanFont
{
    const mmCharacterRange = "[\u1000-\u109F]";

    public static function prepareValidRegExp(string $pattern)
    {
        if (strpos($pattern, RuleBase::WHITESPACE) !== false) {
            $pattern = str_replace(RuleBase::WHITESPACE, '', $pattern);
            $pattern = json_decode('"' . $pattern . '"');
            $pattern = "~" . RuleBase::WHITESPACE . $pattern . "~u";

        } else {
            $pattern = "~" . json_decode('"' . $pattern . '"') . "~u";
        }

        return $pattern;
    }

    public static function fontDetect(string $content, $default = 'zawgyi')
    {
        if (!self::isValidMyanmarSar($content))
            return '';

        //escape non-printing character.
        $content = preg_replace(self::prepareValidRegExp('\u200B'), '', trim($content));

        // create unicode, zawgyi occurence counter
        $unicode = $zawgyi = 0;

        foreach (RuleBase::$ruleSet as $fontRule => $ruleSet) {
            $ $fontRule = 0;

            foreach ($ruleSet as $key => $rule) {

                if (strpos($rule, chr(13)) !== false) {
                    $rule = Rabbit::parseline($rule);
                }

                $rule = self::prepareValidRegExp($rule);
                $matchCount = preg_match($rule, $content);
                $ $fontRule += $matchCount;
            }
        }

        if ($unicode > $zawgyi) {
            return 'unicode';
        } else if ($unicode < $zawgyi) {
            return 'zawgyi';
        } else {
            // default zawgyi return
            return $default;
        }
    }

    public static function isMyanmarSar(string $content)
    {
        return (bool)preg_match(self::prepareValidRegExp(self::mmCharacterRange), $content);
    }

    public static function isValidMyanmarSar(string $content)
    {
        // check valid string
        if (!is_string($content) || $content === '')
            return false;

        // check myanmar sar
        return self::isMyanmarSar($content);
    }

    // wrapper around Rabbit Converter
    public static function __callStatic($method, $arguments)
    {
        if (method_exists('Rabbit', $method)) {
            $output = call_user_func('Rabbit::' . $method, $arguments);
            if (!empty($output)) {
                return $output[0];
            } else {
                return '';
            }

        } else {
            throw new Exception('Undefined method call.');
        }
    }

}