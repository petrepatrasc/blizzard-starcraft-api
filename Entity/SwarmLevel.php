<?php

namespace petrepatrasc\BlizzardApiBundle\Entity;


class SwarmLevel
{

    /**
     * @var int
     */
    protected $level;

    /**
     * @var int
     */
    protected $totalLevelXp;

    /**
     * @var int
     */
    protected $currentLevelXp;

    /**
     * @param int $currentLevelXp
     * @return $this
     */
    public function setCurrentLevelXp($currentLevelXp)
    {
        $this->currentLevelXp = $currentLevelXp;
        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentLevelXp()
    {
        return $this->currentLevelXp;
    }

    /**
     * @param int $level
     * @return $this
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $totalLevelXp
     * @return $this
     */
    public function setTotalLevelXp($totalLevelXp)
    {
        $this->totalLevelXp = $totalLevelXp;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalLevelXp()
    {
        return $this->totalLevelXp;
    }


}