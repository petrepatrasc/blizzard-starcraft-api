<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Reward;

class Animation extends Resource
{
    /**
     * @var string
     */
    protected $command;

    /**
     * @param string $command
     * @return $this
     */
    public function setCommand($command)
    {
        $this->command = $command;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }


}