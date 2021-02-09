<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/8/4
 * Time: 下午9:52
 */
namespace EasySwoole\Consul\Test;

use EasySwoole\Consul\Config;
use EasySwoole\Consul\Consul;
use EasySwoole\Consul\Request\Catalog\Connect;
use EasySwoole\Consul\Request\Catalog\Datacenters;
use EasySwoole\Consul\Request\Catalog\DeRegister;
use EasySwoole\Consul\Request\Catalog\Node;
use EasySwoole\Consul\Request\Catalog\Nodes;
use EasySwoole\Consul\Request\Catalog\Register;
use EasySwoole\Consul\Request\Catalog\Service;
use EasySwoole\Consul\Request\Catalog\Services;
use PHPUnit\Framework\TestCase;

class CatalogTest extends TestCase
{
    protected $config;
    protected $consul;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->config = new Config();
        $this->config->setIP('127.0.0.1');
        $this->config->setPort('8500');
        $this->config->setVersion('v1');
        $this->consul = new Consul($this->config);
        parent::__construct($name, $data, $dataName);
    }

    public function testRegister()
    {
        $register = new Register([
            "datacenter" => "dc1",
            "id" => "40e4a748-2192-161a-0510-9bf59fe950b5",
            "node" => "foobar",
            "Address" => "192.168.10.10",
            "TaggedAddresses" => [
                "lan" => "192.168.10.10",
            "wan" => "10.0.10.10"
            ],
            "NodeMeta" => [
                "somekey" => "somevalue"
            ],
            "Service" => [
                "ID" => "redis1",
            "Service" => "redis",
            "Tags" => [
                    "primary",
                    "v1"
                ],
                "Address" => "127.0.0.1",
                "TaggedAddresses" => [
                "lan" => [
                        "address" => "127.0.0.1",
                    "port" => 8000,
                  ],
                "wan" => [
                    "address" => "198.18.0.1",
                "port" => 80
                ]
                ],
                "Meta" => [
                    "redis_version" => "4.0"
                ],
                "Port" => 8000
            ],
            "Check" => [
                "Node" => "foobar",
            "CheckID" => "service:redis1",
            "Name" => "Redis health check",
            "Notes" => "Script based health check",
            "Status" => "passing",
            "ServiceID" => "redis1",
            "Definition" => [
                    "TCP" => "localhost:8888",
              "Interval" => "5s",
              "Timeout" => "1s",
              "DeregisterCriticalServiceAfter" => "30s"
            ]
            ],
            "SkipNodeUpdate" => false
        ]);
        $this->consul->catalog()->register($register);
        $this->assertEquals('x', 'x');
    }

    public function testDeRegister()
    {
        $deregister = new DeRegister([
            "datacenter" => "dc1",
            "node" => "foobar",
            "CheckID" => "service:redis1",
        ]);
        $this->consul->catalog()->deRegister($deregister);
        $this->assertEquals('x', 'x');
    }

    public function testDatacenters()
    {
        $datacenters = new DataCenters();
        $this->consul->catalog()->dataCenters($datacenters);
        $this->assertEquals('x', 'x');
    }

    public function testNodes()
    {
        $nodes = new Nodes([
            'dc' => 'dc1',
            'node-meta' => '',
            'near' => '',
            'filter' => '',
        ]);
        $this->consul->catalog()->nodes($nodes);
        $this->assertEquals('x', 'x');
    }

    public function testServices()
    {
        $services = new Services([
            'dc' => 'dc1',
            'node-meta' => '',
        ]);
        $this->consul->catalog()->services($services);
        $this->assertEquals('x', 'x');
    }

    public function testService()
    {
        $service = new Service([
            'service' => 'consul',
            'dc' => 'dc1',
            'tag' => '',
            'near' => '',
            'node-meta' => '',
            'filter' => '',
        ]);
        $this->consul->catalog()->service($service);
        $this->assertEquals('x', 'x');
    }

    public function testConnect()
    {
        $connect = new Connect([
            'service' => 'consul',
            'dc' => 'dc1',
            'tag' => '',
            'near' => '',
            'node-meta' => '',
            'filter' => '',
        ]);
        $this->consul->catalog()->connect($connect);
        $this->assertEquals('x', 'x');
    }

    public function testNode()
    {
        $node = new Node([
            'node' => '2eb87046a6fe',
            'dc' => 'dc1',
            'filter' => '',
        ]);
        $this->consul->catalog()->node($node);
        $this->assertEquals('x', 'x');
    }
}
