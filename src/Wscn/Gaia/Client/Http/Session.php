<?php
// +----------------------------------------------------------------------
// | gaia-client
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/6/10 下午5:10
// +----------------------------------------------------------------------
// + Session.php
// +----------------------------------------------------------------------
namespace Wscn\Gaia\Client\Http;

use Wscn\Gaia\Client\Contracts\SessionInterface;

class Session implements SessionInterface
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key)
    {
        unset($_SESSION[$key]);
    }
}