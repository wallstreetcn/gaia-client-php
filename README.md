## 见闻单点登录客户端 PHP 版
用于非主站项目集成 passport 登录，目前只支持 wallstreetcn.com 根域名下的应用。

## 基础用法
在项目 composer.json 中加入
```json
{
	"require" : {
		"wallstreetcn/gaia-client-php":"dev-master"
	},
	"repositories" : [
		{
			"type": "git",
			"url": "git@github.com:wallstreetcn/gaia-client-php.git"
		}
	]
}
```

PHP 代码调用说明：

```php
use Wscn\Gaia\Client\Services\User;


// 在应用中需要登录的路由被请求前实例化 `UserService`
$userService = new User();
// 判断用户是否已经登录，返回的是 bool 值
$userService->isLoggedIn();
// 获取当前已登录的用户，返回的是 `Wscn\Gaia\Client\Entities\LoggedInUser` 对象
$userService->getCurrentUser();
// 获取单点退出链接，返回的是地址字符串
$userService->getLogoutUrl($next='退出后跳转的绝对 URL，如不传入则退出后跳回当前页');
// 获取登录地址，返回的是地址字符串
$userService->getLoginUrl($next='登录成功后跳转的绝对 URL，如不传入则跳转到用户中心');
```

## 组件替换
`gaia-client-php` 实现了控制反转，可以在外部替换各种默认对象。

### Cookie 和 Session
gaia-client-php 依赖了 Cookie 和 Session， Cookie 和 Session 在不同的应用中通常有自己的实现，可以通过实现自己的 `Wscn\Gaia\Client\Contracts\CookieInterface` 和 `Wscn\Gaia\Client\Contracts\SessionInterface` ，然后传递给 `Wscn\Gaia\Client\Services\User` 的构造函数。

### 配置
`Wscn\Gaia\Client\Config` 中的默认参数可以替换，替换方式为手动实例化一个 Config 对象，通过 setter (setXXX)修改配置项，然后传给 `Wscn\Gaia\Client\Services\User` 的构造函数。