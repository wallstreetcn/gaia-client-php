<?php
// +----------------------------------------------------------------------
// | gaia-client
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 15/5/27 下午2:13
// +----------------------------------------------------------------------
// + LoggedInUser.php
// +----------------------------------------------------------------------
namespace Wscn\Gaia\Client\Entities;

class LoggedInUser implements \JsonSerializable
{
    /**
     * @var string 用户 ID
     */
    protected $id;
    /**
     * @var string 用户名
     */
    protected $username;
    /**
     * @var string 用户状态
     */
    protected $status;
    /**
     * @var string 邮箱
     */
    protected $email;
    /**
     * @var string 邮箱激活状态
     */
    protected $emailStatus;
    /**
     * @var string 手机
     */
    protected $mobile;
    /**
     * @var string 手机激活状态
     */
    protected $mobileStatus;
    /**
     * @var string 昵称
     */
    protected $screenName;
    /**
     * @var string 头像
     */
    protected $avatar;
    /**
     * @var string 单点登录 token
     */
    protected $gaiaTicket;

    /**
     * @var array 用户拥有的角色
     */
    protected $roles;

    public function __construct(array $userArr)
    {
        $this->assign($userArr);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmailStatus()
    {
        return $this->emailStatus;
    }

    /**
     * @param string $emailStatus
     */
    public function setEmailStatus($emailStatus)
    {
        $this->emailStatus = $emailStatus;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string
     */
    public function getMobileStatus()
    {
        return $this->mobileStatus;
    }

    /**
     * @param string $mobileStatus
     */
    public function setMobileStatus($mobileStatus)
    {
        $this->mobileStatus = $mobileStatus;
    }

    /**
     * @return string
     */
    public function getScreenName()
    {
        return $this->screenName;
    }

    /**
     * @param string $screenName
     */
    public function setScreenName($screenName)
    {
        $this->screenName = $screenName;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public function getGaiaTicket()
    {
        return $this->gaiaTicket;
    }

    /**
     * @param string $gaiaTicket
     */
    public function setGaiaTicket($gaiaTicket)
    {
        $this->gaiaTicket = $gaiaTicket;
    }

    /**
     * 获取用户的角色
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * 设置用户的角色
     *
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    public function assign(array $user)
    {
        foreach ($user as $filed => $value) {
            $setterMethodName = 'set' . ucwords($filed);
            if (isset($this->$filed) || method_exists($this, $setterMethodName)) {
                $this->$setterMethodName($value);
            }
        }
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return json_encode($this->toArray());
    }
}