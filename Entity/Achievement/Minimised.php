<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Achievement;

/**
 * Minimised information regarding an achievement. It's essentially a smaller version of the Achievement\Standard entity,
 * but they don't quite have a parent -> child relationship.
 * @package petrepatrasc\BlizzardApiBundle\Entity\Achievement
 */
class Minimised
{

    /**
     * The title of the achievement.
     *
     * @var string
     */
    protected $title;

    /**
     * The category ID of the achievement.
     *
     * @var int
     */
    protected $categoryId;

    /**
     * The achievement ID that is featured by this entry.
     *
     * @var int
     */
    protected $featuredAchievementId;

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
     * @param int $featuredAchievementId
     * @return $this
     */
    public function setFeaturedAchievementId($featuredAchievementId)
    {
        $this->featuredAchievementId = $featuredAchievementId;
        return $this;
    }

    /**
     * @return int
     */
    public function getFeaturedAchievementId()
    {
        return $this->featuredAchievementId;
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