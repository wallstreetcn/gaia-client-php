<?php
// +----------------------------------------------------------------------
// | gaia-client
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/5/27 下午2:23
// +----------------------------------------------------------------------
// + CookieInterface.php
// +----------------------------------------------------------------------
namespace Wscn\Gaia\Client\Contracts;

interface CookieInterface
{
    /**
     * 从 cookie 中获取一个值
     *
     * @param string $key cookie 键名
     * @return string
     */
    public function get($key);

    /**
     * 保存一个值到 cookie
     *
     * @param string $key cookie 键名
     * @param string $value cookie 值
     * @param null $expire
     * @param null $path
     * @param string $domain 域名
     * @param null $secure
     * @param null $httponly
     * @return mixed
     */
    public function set(
        $key,
        $value = null,
        $expire = null,
        $path = null,
        $domain = null,
        $secure = null,
        $httponly = null
    );

    /**
     * 判断 cookie 中是否有 $key
     *
     * @param string $key session 键名
     * @return mixed
     */
    public function exists($key);

    /**
     * 删除 cookie 中的 $key
     * @param string $key session 键名
     * @param string $domain 域名
     * @param string $path
     * @return mixed
     */
    public function delete($key, $domain, $path = '/');
}