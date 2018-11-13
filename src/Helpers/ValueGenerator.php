<?php
namespace App\Helpers;

class ValueGenerator {
    const CODE_LENGHT = 6;

    public static function code() {
        $out = '';
        for($i = 0; $i < self::CODE_LENGHT; $i++) {
            $out.=rand(0,9);
        }
        return $out;
    }

    public static function token() {
        return \md5(\date('YmdHis').rand(0, 65535));
    }
}