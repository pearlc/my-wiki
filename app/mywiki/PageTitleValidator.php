<?php

namespace mywiki;

use mywiki\helpers\StringHelper;

class PageTitleValidator
{
    static public function validate($title)
    {
        if (!self::isContainRestrictedCharacter($title)) {
            return false;
        }
        return true;
    }


    static public function isContainRestrictedCharacter($title)
    {
        /**
         *
         * 코드값 참고 : http://ko.wikipedia.org/wiki/%EC%9C%A0%EB%8B%88%EC%BD%94%EB%93%9C_0000~0FFF
         *
         * #(U+0023)　<(U+003C)　>(U+003E)　[(U+005B)　](U+005D)　|(U+007C)　{(U+007B)　}(U+007D)
         *
         * U+0000부터 U+001F까지와 U+007F~U+00A0
         */

        $controlCodeScope1 = [
            0x00,   // NUL ~
            0x1F,   // US
        ];

        $controlCodeScope2 = [
            0x7F,   // DEL ~
            0xA0,   // NBSP
        ];

        $specialChars = [
            0x23,   // #
            0x3C,   // <
            0x3E,   // >
            0x5B,   // [
            0x5D,   // ]
            0x7C,   // |
            0x7B,   // {
            0x7D,   // }
        ];

        $strlen = mb_strlen($title, 'utf-8');
        $notValidSet = [];

        for ($i=0 ; $i<($strlen) ; $i++) {
            $char = mb_substr($title, $i, 1, 'utf-8');
            $unicode = StringHelper::uniord($char);

            if (
                ($controlCodeScope1[0] >= $unicode && $controlCodeScope1[1] <= $unicode) ||
                ($controlCodeScope2[0] >= $unicode && $controlCodeScope2[1] <= $unicode) ||
                in_array($unicode, $specialChars)
            ) {
                if (!in_array($char, $notValidSet)) {
                    $notValidSet[] = $char;
                }
            }
        }

        if (count($notValidSet) > 0) {
            return false;
        } else {
            return true;
        }
    }
}
