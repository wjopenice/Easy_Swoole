<?php
namespace EasySwoole\Consul\Request\Agent\Health\Service;

use EasySwoole\Consul\Request\BaseCommand;

class Name extends BaseCommand
{
    protected $url = 'agent/health/service/name/%s';

    /**
     * @var string
     */
    protected $service_name;
    /**
     * @var string
     */
    protected $format;
    /**
     * @return string|null
     */
    public function getServiceName(): ?string
    {
        return $this->service_name;
    }

    /**
     * @param string $serviceName
     */
    public function setServiceName(string $serviceName): void
    {
        $this->service_name = $serviceName;
    }

    /**
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }
}
