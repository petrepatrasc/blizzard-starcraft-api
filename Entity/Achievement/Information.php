<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Achievement;


class Information
{

    /**
     * @var array
     */
    protected $achievements;

    /**
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