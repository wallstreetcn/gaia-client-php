<?php
// +----------------------------------------------------------------------
// | gaia-client
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/5/27 下午5:11
// +----------------------------------------------------------------------
// + Config.php
// +----------------------------------------------------------------------

namespace Wscn\Gaia\Client;

class Config
{
    /**
     * @var string 单点登录 ticket 在 cookie 中的名字
     */
    protected $sso_ticket_name = '_gaia_ticket';
    /**
     * @var string ticket cookie 所在域名
     */
    protected $sso_domain = '.wallstreetcn.com';
    /**
     * @var string passport基础路径
     */
    protected $passport_base = 'http://passport.wallstreetcn.com';
    /**
     * @var string 本地 session，用于存储用户信息
     */
    protected $session_key = '_gaia_session';

    /**
     * @return string
     */
    public function getSsoTicketName()
    {
        return $this->sso_ticket_name;
    }

    /**
     * @param string $sso_ticket_name
     */
    public function setSsoTicketName($sso_ticket_name)
    {
        $this->sso_ticket_name = $sso_ticket_name;
    }

    /**
     * @return string
     */
    public function getSsoDomain()
    {
        return $this->sso_domain;
    }

    /**
     * @param string $sso_domain
     */
    public function setSsoDomain($sso_domain)
    {
        $this->sso_domain = $sso_domain;
    }

    /**
     * @return string
     */
    public function getPassportBase()
    {
        return $this->passport_base;
    }

    /**
     * @param string $passport_base
     */
    public function setPassportBase($passport_base)
    {
        $this->passport_base = $passport_base;
    }

    /**
     * @return string
     */
    public function getSessionKey()
    {
        return $this->session_key;
    }

    /**
     * @param string $session_key
     */
    public function setSessionKey($session_key)
    {
        $this->session_key = $session_key;
    }


}