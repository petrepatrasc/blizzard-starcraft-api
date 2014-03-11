<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Player;


use petrepatrasc\BlizzardApiBundle\Entity;

class Achievements
{

    /**
     * @var Entity\Achievement\Points
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
     * @param Entity\Achievement\Points $points
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;
        return $this;
    }

    /**
     * @return Entity\Achievement\Points
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param Entity\Achievement $achievement
     * @return $this
     */
    public function addAchievements(Entity\Achievement $achievement)
    {
        $this->achievements[] = $achievement;
        return $this;
    }
}