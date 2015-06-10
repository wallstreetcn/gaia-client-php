<?php
// +----------------------------------------------------------------------
// | gaia-client
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/5/27 下午2:23
// +----------------------------------------------------------------------
// + SessionInterface.php
// +----------------------------------------------------------------------
namespace Wscn\Gaia\Client\Contracts;

interface SessionInterface
{
    /**
     * 从 session 中获取一个值
     *
     * @param string $key session 键名
     * @return string
     */
    public function get($key);

    /**
     * 保存一个值到 session
     *
     * @param string $key session 键名
     * @param string $value session 值
     * @return mixed
     */
    public function set($key, $value);

    /**
     * 判断 session 中是否有 $key
     *
     * @param string $key session 键名
     * @return mixed
     */
    public function exists($key);

    /**
     * 删除 session 中的 $key
     * @param string $key session 键名
     * @return mixed
     */
    public function delete($key);

}