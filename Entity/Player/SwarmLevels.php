<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Player;


use petrepatrasc\BlizzardApiBundle\Entity;

class SwarmLevels
{

    /**
     * @var int
     */
    protected $playerLevel;

    /**
     * @var Entity\SwarmLevel
     */
    protected $terranLevel;

    /**
     * @var Entity\SwarmLevel
     */
    protected $zergLevel;

    /**
     * @var Entity\SwarmLevel
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
     * @param Entity\SwarmLevel $protossLevel
     * @return $this
     */
    public function setProtossLevel($protossLevel)
    {
        $this->protossLevel = $protossLevel;
        return $this;
    }

    /**
     * @return Entity\SwarmLevel
     */
    public function getProtossLevel()
    {
        return $this->protossLevel;
    }

    /**
     * @param Entity\SwarmLevel $terranLevel
     * @return $this
     */
    public function setTerranLevel($terranLevel)
    {
        $this->terranLevel = $terranLevel;
        return $this;
    }

    /**
     * @return Entity\SwarmLevel
     */
    public function getTerranLevel()
    {
        return $this->terranLevel;
    }

    /**
     * @param Entity\SwarmLevel $zergLevel
     * @return $this
     */
    public function setZergLevel($zergLevel)
    {
        $this->zergLevel = $zergLevel;
        return $this;
    }

    /**
     * @return Entity\SwarmLevel
     */
    public function getZergLevel()
    {
        return $this->zergLevel;
    }


}