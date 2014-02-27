<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Player;


use petrepatrasc\BlizzardApiBundle\Entity\Achievement\Points;
use petrepatrasc\BlizzardApiBundle\Entity\Achievement;

class Achievements
{

    /**
     * @var Points
     */
    protected $points;

    /**
     * @var array
     */
    protected $achievements;

    /**
     * @param array $achievements
     * @return $this
     */
    public function setAchievements($achievements)
    {
        $this->achievements = $achievements;
        return $this;
    }

    /**
     * @return array
     */
    public function getAchievements()
    {
        return $this->achievements;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\Achievement\Points $points
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\Achievement\Points
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param Achievement $achievement
     * @return $this
     */
    public function addAchievements(Achievement $achievement)
    {
        $this->achievements[] = $achievement;
        return $this;
    }
}