<?php
// +----------------------------------------------------------------------
// | gaia-client
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/5/27 下午5:10
// +----------------------------------------------------------------------
// + Config.php
// +----------------------------------------------------------------------

namespace Wscn\Gaia\Client;

class Container
{
    protected static $services = array();

    protected static function set($name, $service)
    {
        static::$services[$name] = $service;
    }

    protected static function get($name)
    {
        return static::$services[$name];
    }

    public static function setConfig(Config $config)
    {
        static::set('config', $config);
    }

    public static function getConfig()
    {
        return static::get('config');
    }
}