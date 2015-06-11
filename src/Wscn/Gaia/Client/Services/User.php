<?php
// +----------------------------------------------------------------------
// | gaia-client
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/5/27 下午2:18
// +----------------------------------------------------------------------
// + User.php
// +----------------------------------------------------------------------
namespace Wscn\Gaia\Client\Services;

use Wscn\Gaia\Client\Config;
use Wscn\Gaia\Client\Contracts\CookieInterface;
use Wscn\Gaia\Client\Contracts\SessionInterface;
use Wscn\Gaia\Client\Contracts\UserDAOInterface;
use Wscn\Gaia\Client\DAO\UserHttpDAO;
use Wscn\Gaia\Client\Entities\LoggedInUser;
use Wscn\Gaia\Client\Http\Cookie;
use Wscn\Gaia\Client\Http\Session;

class User
{
    /**
     * @var CookieInterface
     */
    protected $cookie;
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var UserDAOInterface
     */
    protected $userDAO;
    /**
     * @var LoggedInUser 当前登录用户
     */
    protected $currentUser;
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param SessionInterface $session
     * @param CookieInterface $cookie
     * @param UserDAOInterface $userDAO
     * @param Config $config
     */
    public function __construct(
        SessionInterface $session = null,
        CookieInterface $cookie = null,
        UserDAOInterface $userDAO = null,
        Config $config = null
    ) {
        $this->session = empty($session) ? new Session() : $session;
        $this->cookie = empty($cookie) ? new Cookie() : $cookie;
        $this->config = empty($config) ? new Config() : $config;
        $this->userDAO = empty($userDAO) ? new UserHttpDAO($this->config) : $userDAO;

        $this->initialize();
    }

    /**
     * 初始化逻辑，生成当前请求的登录信息与状态。
     *
     * @return bool
     */
    protected function initialize()
    {
        // cookie 中没有 ticket ，则说明已经单点退出
        if (!$this->cookie->exists($this->config->getSsoTicketName())) {
            return $this->logout();
        }

        // 取 cookie 中的 ticket（一般是账户中心写在根域名，与 client 无关）
        $ticket = $this->cookie->get($this->config->getSsoTicketName());

        // 从 session 中获取登录用户
        $this->currentUser = unserialize($this->session->get($this->config->getSessionKey()));
        // 没有登录本地系统
        if (!$this->currentUser instanceof LoggedInUser || !$this->isLoggedIn()) {
            $this->loginByTicket($ticket);
        }

        // session 中的 ticket 与 cookie 中的 ticket 不一致，重新登录
        if ($this->currentUser->getGaiaTicket() != $ticket) {
            $this->loginByTicket($ticket);
        }

    }

    /**
     * 通过 gaia ticket 来登录
     *
     * @param string $ticket 单点登录票据
     * @return bool
     */
    protected function loginByTicket($ticket)
    {
        $this->currentUser = $this->userDAO->getSSOUser($ticket);

        // ticket 无效
        if (!$this->isLoggedIn()) {
            $this->logout();
        } else {
            $this->currentUser->setGaiaTicket($ticket);
            $this->session->set($this->config->getSessionKey(), serialize($this->currentUser));

            return true;
        }

        return false;
    }

    /**
     * 判断用户是否已经登录
     *
     * @return bool
     */
    public function isLoggedIn()
    {
        return $this->currentUser instanceof LoggedInUser && $this->currentUser->getId() > 0;
    }

    /**
     * 退出
     *
     * @return bool
     */
    public function logout()
    {
        // 删除本地 session
        if ($this->session->exists($this->config->getSessionKey())) {
            $this->session->delete($this->config->getSessionKey());
        }
        // 删除 cookie 中的 gaia ticket
        if ($this->cookie->exists($this->config->getSsoTicketName())) {
            $this->cookie->delete($this->config->getSsoTicketName(), $this->config->getSsoDomain());
        }

        return true;
    }

    /**
     * 获取当前登录用户
     *
     * @return LoggedInUser
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * 获取用户未登录时的跳转地址
     *
     * @param string $next
     * @return string
     */
    public function getLoginUrl($next = '')
    {
        $passportBase = $this->config->getPassportBase();
        $url = rtrim($passportBase, '/') . '/login';
        if ($next) {
            $url .= '?next=' . urlencode($next);
        }

        return $url;
    }

    /**
     * 获取退出链接
     *
     * @param string $next
     * @return string
     */
    public function getLogoutUrl($next = '')
    {
        $passportBase = $this->config->getPassportBase();
        $url = rtrim($passportBase, '/') . '/logout';
        if ($next) {
            $url .= '?next=' . urlencode($next);
        }

        return $url;

    }
}
