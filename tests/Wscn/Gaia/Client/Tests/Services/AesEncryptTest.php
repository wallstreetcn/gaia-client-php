<?php
/**
 * Wscn
 *
 * @link: https://github.com/wallstreetcn/wallstreetcn
 * @author: franktung<franktung@gmail.com>
 * @Date: 15/12/22
 * @Time: 下午4:18
 *
 */

namespace Wscn\Gaia\Client\Tests\Services;


use Wscn\Gaia\Client\Services\AesEncrypt;

class AesEncryptTest extends \PHPUnit_Framework_TestCase
{

    const TEST_STRING = 'The "Dangerous" magician \'John\' jumped d0wn from Eiffel Tower!?';


    /**
     * @param $method
     * @param $iv
     *
     * @dataProvider encryptProvider
     */
    public function testCanEncrypt($method, $iv)
    {
        $this->simpleAssert($method, $iv, self::TEST_STRING);
    }

    private function simpleAssert($method, $iv, $data)
    {
        $aes = new AesEncrypt($this->generateKey(), $method, $iv);
        $encrypted = $aes->encrypt($data);
        $result = $aes->decrypt($encrypted);
        $this->assertEquals($data, $result);
    }


    private function generateKey()
    {
        return bin2hex(openssl_random_pseudo_bytes(mt_rand(0, 100)));
    }

    public function encryptProvider()
    {
        return [
            [128, 'testIv']
        ];
    }
}
