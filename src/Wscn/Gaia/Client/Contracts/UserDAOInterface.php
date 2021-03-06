<?php
// +----------------------------------------------------------------------
// | gaia-client
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/5/29 下午5:12
// +----------------------------------------------------------------------
// + UserDAOInterface.php
// +----------------------------------------------------------------------

namespace Wscn\Gaia\Client\Contracts;

interface UserDAOInterface
{
    /**
     * 获取单点登录用户
     *
     * @param string $ticket 单点登录凭证
     * @return mixed
     */
    public function getSSOUser($ticket);
}