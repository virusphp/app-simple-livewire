<?php

namespace App\Helpers;

date_default_timezone_set('UTC');

class HelperGenerator
{
    public static function signature($cusid, $secid)
    {
        $timestamps = strval(time()-strtotime('1970-01-01 00:00:00'));
        $ensig = hash_hmac('sha256', $cusid."&".$timestamps, $secid, true);
        $signature = base64_encode($ensig);
        return $signature;
    }

    public static function timestamp()
    {
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        return $timestamp;
    }

    public static function enkripsi($passid)
    { 
        return MD5($passid);
    }
    
    // public static function keyString($conid, $secid)
    // {
    //     $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
    //     return $conid.$secid.$timestamp;
    // }

    // public static function stringDecrypt($key, $string)
    // {
    //     $encrtyp_method = 'AES-256-CBC';

    //     $key_hash = hex2bin(hash('sha256', $key));

    //     $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

    //     $output = openssl_decrypt(base64_decode($string), $encrtyp_method, $key_hash, OPENSSL_RAW_DATA, $iv);

    //     return $output;
    // }

    // public static function stringEncrtypt($key, $string)
    // {
    //     $encrtyp_method = 'AES-256-CBC';

    //     $iv = substr($key, 0, 16);

    //     $output = base64_encode(openssl_encrypt($string, $encrtyp_method, $key, OPENSSL_RAW_DATA, $iv));

    //     return $output;
       
    // }

}
