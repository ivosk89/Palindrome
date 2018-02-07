<?php

class Palindrome
{

    private static $_instance = null;


    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (self::$_instance === NULL) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * @param string $str
     * @return string
     */
    public function checkStr($str)
    {
        $modifiedStr = mb_strtolower(str_replace(' ', '', $str), 'utf8');
        // The whole text is palindrome
        if ($this->isPalindrome($modifiedStr)) {
            return $str;
        }

        $subPalindromes = [];
        // Compare substrings (left -> center <- right)
        for ($i = 1; $i < mb_strlen($modifiedStr, 'utf8') - 1; $i++) {
            for ($j = mb_strlen($modifiedStr, 'utf8') - $i; $j > 1; $j--) {
                $subStr = mb_substr($modifiedStr, $i, $j, 'utf8');
                if ($this->isPalindrome($subStr)) {
                    $subPalindromes[] = $subStr;
                }
            }
        }

        // No sub palindromes in text; return first letter
        if (!$subPalindromes) {
            return mb_substr($str, 0, 1, 'utf8');
        }

        // Return the longest sub palindrome
        usort($subPalindromes, function ($sp1, $sp2) {
            return mb_strlen($sp1, 'utf8') - mb_strlen($sp2, 'utf8');
        });

        return end($subPalindromes);
    }

    /**
     * @param string $str
     * @return bool
     */
    private function isPalindrome($str)
    {

        return $str == $this->reverseStr($str);
    }

    /**
     * @param string $str
     * @return string
     */
    private function reverseStr($str)
    {
        // Divide text by characters including unicode
        preg_match_all('/./u', $str, $strArr);

        return implode('', array_reverse(reset($strArr)));
    }

}