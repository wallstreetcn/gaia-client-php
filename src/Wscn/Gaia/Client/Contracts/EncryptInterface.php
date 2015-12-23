<?php
/**
 * Wscn
 *
 * @link: https://github.com/wallstreetcn/wallstreetcn
 * @author: franktung<franktung@gmail.com>
 * @Date: 15/12/22
 * @Time: 下午5:35
 *
 */

namespace Wscn\Gaia\Client\Contracts;


interface EncryptInterface
{
    public function encrypt($str);

    public function decrypt($str);
}