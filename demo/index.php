<?php
// +----------------------------------------------------------------------
// | gaia-client-php
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/6/11 上午10:23
// +----------------------------------------------------------------------
// + index.php
// +----------------------------------------------------------------------
require __DIR__ . '/../vendor/autoload.php';
$userService = new \Wscn\Gaia\Client\Services\User();
if (!$userService->isLoggedIn()) {
    header('Location: ' . $userService->getLoginUrl('http://gaia-demo.wallstreetcn.com/index.php'));
    exit();
}
//var_dump($userService->getCurrentUser());
$user = $userService->getCurrentUser();
require __DIR__ . '/index.phtml';