<?php
/**
 * Wscn
 *
 * @link: https://github.com/wallstreetcn/wallstreetcn
 * @author: franktung<franktung@gmail.com>
 * @Date: 15/12/22
 * @Time: 下午5:39
 *
 */

namespace Wscn\Gaia\Client\Services;


use Wscn\Gaia\Client\Contracts\EncryptInterface;

class AesEncrypt implements EncryptInterface
{

    /**
     * @var string
     */
    private $iv;    //Initialization Vector

    /**
     * @var string
     */
    private $key;

    /**
     * @var int
     */
    private $bit; //Only can use 128, 256

    public function __construct($key, $bit = 128, $iv = "") {
        $this->bit = $bit;
        $this->key = hash('MD5', $key, true);
        if ($bit == 256) {
            $this->key = hash('SHA256', $key, true);
        }
        $this->iv = hash('MD5', $iv, true);
        if ($iv == "") {
            $this->iv = chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0); //IV is not set. It doesn't recommend.
        }
    }

    public function encrypt($str) {
        //Open
        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($module, $this->key, $this->iv);

        //Padding
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC); //Get Block Size
        $pad = $block - (strlen($str) % $block); //Compute how many characters need to pad
        $str .= str_repeat(chr($pad), $pad); // After pad, the str length must be equal to block or its integer multiples

        //Encrypt
        $encrypted = mcrypt_generic($module, $str);

        //Close
        mcrypt_generic_deinit($module);
        mcrypt_module_close($module);

        //Return
        return base64_encode($encrypted);
    }

    public function decrypt($str) {
        //Open
        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($module, $this->key, $this->iv);

        //Decrypt
        $str = mdecrypt_generic($module, base64_decode($str)); //Get original str

        //Close
        mcrypt_generic_deinit($module);
        mcrypt_module_close($module);

        //Depadding
        $slast = ord(substr($str, -1)); //pad value and pad count
        $str = substr($str, 0, strlen($str) - $slast);

        //Return
        return $str;
    }
}