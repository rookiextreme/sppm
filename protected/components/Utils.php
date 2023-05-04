<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Utils 
{
    const MAK_MINAH = 'mak minah balik kampung';
    const STR_ENC1 = 'qyA7ltzJy3';
    const STR_ENC2 = 'YRGg2hXmMz';
    
    // Flag field is_bin
    const DELETED = 1;
    const NOT_DELETED = 0; // or null

    // Flag field flag_aktif
    const FLAG_AKTIF = 1;
    const FLAG_TAK_AKTIF = 0;
    
    const ALAMAT_BHG_SEKRETARIAT = "Bahagian Sekretariat,<br />
                   Cawangan Dasar dan Pengurusan Korporat,<br />
                   Ibu Pejabat JKR Malaysia,<br />
                   Jalan Sultan Salahuddin,<br />
                   50582, Kuala Lumpur<br />
                   Tel: 03-2618 8698 / 8688 / 8692<br />";
    
    // Displayed status by flag_aktif
    public static $listStatus = Array(
        self::FLAG_AKTIF => 'Aktif',
        self::FLAG_TAK_AKTIF => 'Tak Aktif'
    );
    
    public static function encode($id) {
        return self::STR_ENC1.$id.self::STR_ENC2;
    }

    public static function decode($id) {
        $id_decode = chop($id, Utils::STR_ENC2);
        return substr($id_decode, 10);
    }

    /**
     * Returns an encrypted & utf8-encoded
     */
    public static function encrypt($pure_string, $encryption_key) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
        return $encrypted_string;
    }

    /**
     * Returns decrypted original string
     */
    public static function decrypt($encrypted_string, $encryption_key) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
        return $decrypted_string;
    }
    
    public static function prnt($data)
    {
        echo '<pre>'.print_r($data,1).'</pre>';
    }
}