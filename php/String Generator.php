<?php
public static function strGen($length = 8, $flag = 'ALPHANUMERIC')
{
    $length = (int) $length;
    if ($length <= 0) {
        return false;
    }
    switch ($flag) {
        case 'NUMERIC':
            $str = '0123456789';
            break;
        case 'NO_NUMERIC':
            $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 'RANDOM':
            $num_bytes = ceil($length * 0.75);
            $bytes = self::getBytes($num_bytes);
            return substr(rtrim(base64_encode($bytes), '='), 0, $length);
        case 'RANDOMALFA':
            $str = "";
            $characters = array_merge(range('A','Z'), range('a','z'));
            $max = count($characters) - 1;
                
            for ($i = 0; $i < $length; $i++) 
            {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
            }
            return $str;
        case 'ALPHANUMERIC':
        default:
            $str = 'abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
    }
    $bytes = self::getBytes($length);
    $position = 0;
    $result = '';
    for ($i = 0; $i < $length; ++$i) {
        $position = ($position + ord($bytes[$i])) % strlen($str);
        $result .= $str[$position];
    }
    return $result;
}

public static function getBytes($length)
{
    $length = (int) $length;
    if ($length <= 0) {
        return false;
    }
    $bytes = openssl_random_pseudo_bytes($length, $cryptoStrong);
    if ($cryptoStrong === true) {
        return $bytes;
    }
    return false;
}