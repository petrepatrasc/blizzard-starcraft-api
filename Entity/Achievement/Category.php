<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Achievement;

class Category
{

    /**
     * @var Minimised
     */
    protected $minimisedAchievement;

    /**
     * @var array
     */
    protected $children;

    /**
     * @param array $children
     * @return $this
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\Achievement\Minimised $entry
     * @return $this
     */
    public function setMinimisedAchievement($entry)
    {
        $this->minimisedAchievement = $entry;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\Achievement\Minimised
     */
    public function getMinimisedAchievement()
    {
        return $this->minimisedAchievement;
    }

}