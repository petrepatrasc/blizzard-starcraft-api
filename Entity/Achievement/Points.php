<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Achievement;


class Points
{

    /**
     * @var int
     */
    protected $totalPoints;

    /**
     * @var array
     */
    protected $categoryPoints;

    /**
     * @param array $categoryPoints
     * @return $this
     */
    public function setCategoryPoints($categoryPoints)
    {
        $this->categoryPoints = $categoryPoints;
        return $this;
    }

    /**
     * @return array
     */
    public function getCategoryPoints()
    {
        return $this->categoryPoints;
    }

    /**
     * @param int $totalPoints
     * @return $this
     */
    public function setTotalPoints($totalPoints)
    {
        $this->totalPoints = $totalPoints;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPoints()
    {
        return $this->totalPoints;
    }


}