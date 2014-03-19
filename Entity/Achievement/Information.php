<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Achievement;

/**
 * Contains achievement information data, which is a general overview on all of the achievements available.
 * @package petrepatrasc\BlizzardApiBundle\Entity\Achievement
 */
class Information
{

    /**
     * The achievements that are currently defined in the system.
     *
     * @var array
     */
    protected $achievements;

    /**
     * The categories that are currently defined in the system.
     *
     * @var array
     */
    protected $categories;

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
     * @param array $categories
     * @return $this
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }


}