<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Achievement;


use petrepatrasc\BlizzardApiBundle\Entity\Icon;

/**
 * Basic Achievement entity data structure. Holds the most detail regarding a single achievement entry.
 * @package petrepatrasc\BlizzardApiBundle\Entity\Achievement
 */
class Standard
{

    /**
     * The title of the achievement.
     *
     * @var string
     */
    protected $title;

    /**
     * The description of the achievement.
     *
     * @var string
     */
    protected $description;

    /**
     * The ID of the achievement.
     *
     * @var int
     */
    protected $achievementId;

    /**
     * The ID of the category that the achievement belongs to.
     *
     * @var int
     */
    protected $categoryId;

    /**
     * The points associated to the achievement.
     *
     * @var int
     */
    protected $points;

    /**
     * The Icon of the achievement.
     *
     * @var Icon
     */
    protected $icon;

    /**
     * @param int $achievementId
     * @return $this
     */
    public function setAchievementId($achievementId)
    {
        $this->achievementId = $achievementId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAchievementId()
    {
        return $this->achievementId;
    }

    /**
     * @param int $categoryId
     * @return $this
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\Icon $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\Icon
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param int $points
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;
        return $this;
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


}