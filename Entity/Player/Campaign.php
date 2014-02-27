<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Player;


class Campaign
{

    /**
     * @var string
     */
    protected $wingsOfLibertyStatus;

    /**
     * @var string
     */
    protected $heartOfTheSwarmStatus;

    /**
     * @param string $heartOfTheSwarmStatus
     * @return $this
     */
    public function setHeartOfTheSwarmStatus($heartOfTheSwarmStatus)
    {
        $this->heartOfTheSwarmStatus = $heartOfTheSwarmStatus;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeartOfTheSwarmStatus()
    {
        return $this->heartOfTheSwarmStatus;
    }

    /**
     * @param string $wingsOfLibertyStatus
     * @return $this
     */
    public function setWingsOfLibertyStatus($wingsOfLibertyStatus)
    {
        $this->wingsOfLibertyStatus = $wingsOfLibertyStatus;
        return $this;
    }

    /**
     * @return string
     */
    public function getWingsOfLibertyStatus()
    {
        return $this->wingsOfLibertyStatus;
    }


}