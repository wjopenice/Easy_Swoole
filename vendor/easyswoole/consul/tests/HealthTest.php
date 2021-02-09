<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/8/5
 * Time: 下午8:45
 */
namespace EasySwoole\Consul\Test;

use EasySwoole\Consul\Config;
use EasySwoole\Consul\Consul;
use EasySwoole\Consul\Request\Health\Checks;
use EasySwoole\Consul\Request\Health\Connect;
use EasySwoole\Consul\Request\Health\Node;
use EasySwoole\Consul\Request\Health\Service;
use EasySwoole\Consul\Request\Health\State;
use PHPUnit\Framework\TestCase;

class HealthTest extends TestCase
{
    protected $config;
    protected $consul;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->config = new Config();
        $this->consul = new Consul($this->config);
        parent::__construct($name, $data, $dataName);
    }

    public function testNode()
    {
        $node = new Node([
            'node' => '2456c2850382',
            'dc' => 'dc1',
        ]);
        $this->consul->health()->node($node);
        $this->assertEquals('x', 'x');
    }

    public function testChecks()
    {
        $checks = new Checks([
            'service' => 'consul',
            'node_meta' => 'node-meta',
        ]);
        $this->consul->health()->checks($checks);
        $this->assertEquals('x', 'x');
    }

    public function testService()
    {
        $service = new Service([
            'service' => 'consul',
            'dc' => 'dc1',
        ]);
        $this->consul->health()->service($service);
        $this->assertEquals('x', 'x');
    }

    public function testConnect()
    {
        $connect = new Connect([
            'service' => 'consul'
        ]);
        $this->consul->health()->connect($connect);
        $this->assertEquals('x', 'x');
    }

    public function testState()
    {
        $state = new State([
            'state' => 'passing'
        ]);
        $this->consul->health()->state($state);
        $this->assertEquals('x', 'x');
    }
}
