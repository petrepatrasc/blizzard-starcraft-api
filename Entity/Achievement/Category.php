<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Achievement;

/**
 * Contains the entity definition for achievement categories.
 * @package petrepatrasc\BlizzardApiBundle\Entity\Achievement
 */
class Category
{

    /**
     * Holds achievement data, but in a minimised format, smaller than the Achievement\Standard definition.
     *
     * @var Minimised
     */
    protected $minimisedAchievement;

    /**
     * Holds the children of the category.
     *
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