<?php
// +----------------------------------------------------------------------
// | gaia-client
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/5/27 下午3:31
// +----------------------------------------------------------------------
// + UserHttpDAO.php
// +----------------------------------------------------------------------
namespace Wscn\Gaia\Client\DAO;

use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;
use Wscn\Gaia\Client\Config;
use Wscn\Gaia\Client\Contracts\UserDAOInterface;
use Wscn\Gaia\Client\Entities\LoggedInUser;

class UserHttpDAO implements UserDAOInterface
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Config $config 配置参数
     * @param ClientInterface $client http 客户端
     */
    public function __construct(Config $config = null, ClientInterface $client = null)
    {
        $this->httpClient = empty($client) ? new Client() : $client;
        $this->config = empty($config) ? new Config() : $config;
    }

    protected function passportUrl($endpoint)
    {
        return rtrim($this->config->getPassportBase(), '/') . '/' . ltrim($endpoint);
    }


    /**
     * @inheritdoc
     */
    public function getSSOUser($ticket)
    {
        $url = $this->passportUrl('/me');
        $resp = $this->httpClient->get($url, [
            'cookies' => array(
                $this->config->getSsoTicketName() => $ticket
            )
        ])->send(null);


        if ($resp->getStatusCode() == 200) {
            $userArr = json_decode($resp->getBody(), true);
            $user = null;
            if ($userArr) {
                $user = new LoggedInUser($userArr);
            }

            return $user;
        }

        return null;
    }
}