<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Reward;


use petrepatrasc\BlizzardApiBundle\Entity\Icon;

class Resource
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var Icon
     */
    protected $icon;

    /**
     * @var int
     */
    protected $achievementId;

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
     * @param Icon $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return Icon
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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