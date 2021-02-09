<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/7/31
 * Time: 下午12:07
 */
namespace EasySwoole\Consul\Request\Acl\Token;

use EasySwoole\Consul\Request\BaseCommand;

class GetSelf extends BaseCommand
{
    protected $url = 'acl/token/self';

    protected $token;

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
}
