<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Player;


class Ladder
{

    /**
     * @var array
     */
    protected $currentSeason;

    /**
     * @var array
     */
    protected $previousSeason;

    /**
     * @var array
     */
    protected $showcasePlacement;

    /**
     * @param array $currentSeason
     * @return $this
     */
    public function setCurrentSeason($currentSeason)
    {
        $this->currentSeason = $currentSeason;
        return $this;
    }

    /**
     * @return array
     */
    public function getCurrentSeason()
    {
        return $this->currentSeason;
    }

    /**
     * @param array $previousSeason
     * @return $this
     */
    public function setPreviousSeason($previousSeason)
    {
        $this->previousSeason = $previousSeason;
        return $this;
    }

    /**
     * @return array
     */
    public function getPreviousSeason()
    {
        return $this->previousSeason;
    }

    /**
     * @param array $showcasePlacement
     * @return $this
     */
    public function setShowcasePlacement($showcasePlacement)
    {
        $this->showcasePlacement = $showcasePlacement;
        return $this;
    }

    /**
     * @return array
     */
    public function getShowcasePlacement()
    {
        return $this->showcasePlacement;
    }


}