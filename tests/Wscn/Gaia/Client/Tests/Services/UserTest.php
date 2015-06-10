<?php
// +----------------------------------------------------------------------
// | gaia-client
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/5/27 下午2:18
// +----------------------------------------------------------------------
// + UserTest.php
// +----------------------------------------------------------------------
namespace Wscn\Gaia\Client\Tests\Services;

use Guzzle\Http\Client;
use Wscn\Gaia\Client\Config;
use Wscn\Gaia\Client\Contracts\CookieInterface;
use Wscn\Gaia\Client\Contracts\SessionInterface;
use Wscn\Gaia\Client\Contracts\UserDAOInterface;
use Wscn\Gaia\Client\DAO\UserHttpDAO;
use Wscn\Gaia\Client\Entities\LoggedInUser;
use Wscn\Gaia\Client\Http\Cookie;
use Wscn\Gaia\Client\Http\Session;
use Wscn\Gaia\Client\Services\User;
use \Mockery as m;


class UserTest extends \PHPUnit_Framework_TestCase
{
    protected function getMockSession()
    {
        return m::mock('\Wscn\Gaia\Client\Http\Session');
    }

    protected function getMockCookie()
    {
        return m::mock('\Wscn\Gaia\Client\Http\Cookie');
    }

    /**
     * @dataProvider redirectUrlProvider
     * @param $next
     * @param $except
     */
    public function testGetLoginRedirectUrl($next, $except)
    {
        $config = new Config();
        $httpClient = new Client();
        $session = $this->getMockSession();
        $session->shouldReceive('exists')->andReturnNull();
        $userService = new User($session, new Cookie(), new UserHttpDAO($config, $httpClient), $config);
        $this->assertEquals($except, $userService->getLoginRedirectUrl($next));
    }

    public function testLogin()
    {
        $config = new Config();
        $session = $this->getMockSession();
        $cookie = $this->getMockCookie();
        $httpClient = m::mock('Guzzle\Http\Client');
        $cookieExists = false;
        $sessionExists = true;
        $cookie->shouldReceive('exists')->with($config->getSsoTicketName())->andReturn($cookieExists);
        $session->shouldReceive('exists')->with($config->getSessionKey())->andReturn($sessionExists);
        $session->shouldReceive('delete')->andReturnNull();

        if (!$cookieExists) {
            $session->shouldReceive('delete')->andReturnNull();
        }
        $userService = new User($session, $cookie, new UserHttpDAO($config, $httpClient), $config);
        $this->assertEquals(false, $userService->isLoggedIn());
        $this->assertTrue(
            in_array(
                $userService->getCurrentUser(),
                [
                    null,
                    new LoggedInUser(
                        json_decode(
                            '{"id":0,"username":"Guest","status":"","email":"","emailStatus":"inactive",' .
                            '"mobile":"","mobileStatus":"inactive","screenName":"","avatar":""}',
                            true
                        )
                    )
                ]
            )
        );
    }

    public function redirectUrlProvider()
    {
        return [
            [
                'http://qq.com',
                'http://passport.wallstreetcn.com/login?next=http%3A%2F%2Fqq.com'
            ],
            [
                'http://markets.wallstreetcn.com/stock?symbol=sh601988&rehabilitation=1',
                'http://passport.wallstreetcn.com/login?next=http%3A%2F%2Fmarkets.wallstreetcn.com%2Fstock%3Fsymbol%3Dsh601988%26rehabilitation%3D1'
            ],
            [
                'http://markets.wallstreetcn.com/这里有点中文',
                'http://passport.wallstreetcn.com/login?next=http%3A%2F%2Fmarkets.wallstreetcn.com%2F%E8%BF%99%E9%87%8C%E6%9C%89%E7%82%B9%E4%B8%AD%E6%96%87'
            ]
        ];
    }
}
