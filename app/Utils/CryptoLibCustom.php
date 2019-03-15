<?php

namespace App\Utils;


use MrShan0\CryptoLib\CryptoLib;

class CryptoLibCustom extends CryptoLib
{
    public function generateRandomIV()
    {
        $length = 16;
        $str = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        return substr(str_shuffle($str), 0, $length);
    }
}