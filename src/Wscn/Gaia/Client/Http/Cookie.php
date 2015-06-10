<?php
// +----------------------------------------------------------------------
// | gaia-client
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/6/10 下午5:10
// +----------------------------------------------------------------------
// + Cookie.php
// +----------------------------------------------------------------------
namespace Wscn\Gaia\Client\Http;

use Wscn\Gaia\Client\Contracts\CookieInterface;

class Cookie implements CookieInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $_COOKIE[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function set(
        $key,
        $value = null,
        $expire = 0,
        $path = null,
        $domain = null,
        $secure = null,
        $httponly = null
    ) {
        return setcookie($key, $value, $expire, '/', $domain, $secure, $httponly);
    }

    /**
     * {@inheritdoc}
     */
    public function exists($key)
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key, $domain, $path = '/')
    {
        return $this->set($key, null, time() - 8640000, $path, $domain);
    }
}