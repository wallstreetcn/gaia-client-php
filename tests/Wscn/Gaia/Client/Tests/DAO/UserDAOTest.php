<?php
// +----------------------------------------------------------------------
// | gaia-client
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/5/27 下午4:42
// +----------------------------------------------------------------------
// + UserDAOTest.php
// +----------------------------------------------------------------------
namespace Wscn\Gaia\Client\Tests\DAO;

use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;
use GuzzleHttp\Psr7\Response;
use \Mockery as m;
use Wscn\Gaia\Client\Config;
use Wscn\Gaia\Client\DAO\UserHttpDAO;
use Wscn\Gaia\Client\Entities\LoggedInUser;

class UserDAOTest extends \PHPUnit_Framework_TestCase
{
    protected function getConfig()
    {
        $config = new Config();
        $config->setPassportBase('http://passport.wallstreetcn.com/');
        $config->setSessionKey('_gaia_session');
        $config->setSsoDomain('.wallstreetcn.com');
        $config->setSsoTicketName('_gaia_ticket');

        return $config;
    }

    protected function getHttpClientMock(
        $respBody = '',
        $headers = array(),
        $status = 200,
        $statusText = 'OK',
        $httpVersion = '1.1'
    ) {

        $_headers = [
            'Content-Encoding' => 'gzip',
            'Content-Type' => 'application/json; charset=utf-8',
            'Server' => 'nginx/1.6.2',
            'Transfer-Encoding' => 'chunked',
            'X-Permission-Auth' => 'Allow-By-Public-Resource',
            'X-Powered-By' => 'PHP/5.5.9-1ubuntu4.9'
        ];
        $headers = array_merge($_headers, $headers);
        $response = new Response($status, $headers, $respBody, $httpVersion, $statusText);
        $client = m::mock('\Guzzle\Http\Client');
        $client->shouldReceive('get')->andReturn($client);
        $client->shouldReceive('send')->andReturn($response);

        return $client;
    }

    /**
     * @dataProvider usersProvider
     */
    public function testGetUser($respUser, $except)
    {
        $respBody = json_encode($respUser);
        $userDAO = new UserHttpDAO($this->getConfig(), $this->getHttpClientMock($respBody));
        $loggedInUser = $userDAO->getSSOUser('ticket');
        $this->assertEquals($loggedInUser, $except);
    }

    public function usersProvider()
    {
        return array(
            [
                [
                    "id" => "123",
                    "username" => "test",
                    "status" => "active",
                    "email" => "mr5.simple@gmail.com",
                    "emailStatus" => "active",
                    "mobile" => "13312341234",
                    "mobileStatus" => "active",
                    "screenName" => "decent",
                    "avatar" => "http://avatar.cdn.wallstcn.com//ab/42/d7/photo.png",
                    "badges" => null,
                    "roles" => array(
                        "USER",
                        "ADMIN"
                    )
                ],
                new LoggedInUser([
                    "id" => "123",
                    "username" => "test",
                    "status" => "active",
                    "email" => "mr5.simple@gmail.com",
                    "emailStatus" => "active",
                    "mobile" => "13312341234",
                    "mobileStatus" => "active",
                    "screenName" => "decent",
                    "avatar" => "http://avatar.cdn.wallstcn.com//ab/42/d7/photo.png",
                    "badges" => null,
                    "roles" => array(
                        "USER",
                        "ADMIN"
                    )
                ])
            ],
            [
                null,
                null
            ]

        );
    }
}