<?php

namespace petrepatrasc\BlizzardApiBundle\Entity;


class PlayerSwarmLevels
{

    /**
     * @var int
     */
    protected $playerLevel;

    /**
     * @var SwarmLevel
     */
    protected $terranLevel;

    /**
     * @var SwarmLevel
     */
    protected $zergLevel;

    /**
     * @var SwarmLevel
     */
    protected $protossLevel;

    /**
     * @param int $playerLevel
     * @return $this
     */
    public function setPlayerLevel($playerLevel)
    {
        $this->playerLevel = $playerLevel;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlayerLevel()
    {
        return $this->playerLevel;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel $protossLevel
     * @return $this
     */
    public function setProtossLevel($protossLevel)
    {
        $this->protossLevel = $protossLevel;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel
     */
    public function getProtossLevel()
    {
        return $this->protossLevel;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel $terranLevel
     * @return $this
     */
    public function setTerranLevel($terranLevel)
    {
        $this->terranLevel = $terranLevel;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel
     */
    public function getTerranLevel()
    {
        return $this->terranLevel;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel $zergLevel
     * @return $this
     */
    public function setZergLevel($zergLevel)
    {
        $this->zergLevel = $zergLevel;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel
     */
    public function getZergLevel()
    {
        return $this->zergLevel;
    }


}