<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/7/28
 * Time: 下午8:34
 */
namespace EasySwoole\Consul\Request\Catalog;

use EasySwoole\Consul\Request\BaseCommand;

class Nodes extends BaseCommand
{
    public $url='catalog/nodes';

    /**
     * @var
     */
    protected $dc;
    /**
     * @var
     */
    protected $near;
    /**
     * @var
     */
    protected $node_meta;
    /**
     * @var
     */
    protected $filter;

    /**
     * @return null|string
     */
    public function getDc(): ?string
    {
        return $this->dc;
    }

    /**
     * @param string $dc
     */
    public function setDc(string $dc): void
    {
        $this->dc = $dc;
    }

    /**
     * @return null|string
     */
    public function getNear(): ?string
    {
        return $this->near;
    }

    /**
     * @param string $near
     */
    public function setNear(string $near): void
    {
        $this->near = $near;
    }

    /**
     * @return null|string
     */
    public function getNodeMeta(): ?string
    {
        return $this->node_meta;
    }

    /**
     * @param string $node_meta
     */
    public function setNodeMeta(string $node_meta): void
    {
        $this->node_meta = json_encode($node_meta);
    }

    /**
     * @return null|string
     */
    public function getFilter(): ?string
    {
        return $this->filter;
    }

    /**
     * @param string $filter
     */
    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
    }

    /**
     * @return array
     */
    protected function setKeyMapping(): array
    {
        return ['node-meta' => 'node_meta'];
    }
}
