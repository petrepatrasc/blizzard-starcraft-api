<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Achievement;


class Minimised
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $categoryId;

    /**
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