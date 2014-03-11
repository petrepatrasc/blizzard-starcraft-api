<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Ladder;


use petrepatrasc\BlizzardApiBundle\Entity;

class Position
{

    /**
     * @var Entity\Player\Basic
     */
    protected $character;

    /**
     * @var \DateTime
     */
    protected $joinDate;

    /**
     * @var float
     */
    protected $points;

    /**
     * @var int
     */
    protected $wins;

    /**
     * @var int
     */
    protected $losses;

    /**
     * @var int
     */
    protected $highestRank;

    /**
     * @var int
     */
    protected $previousRank;

    /**
     * @var string
     */
    protected $favoriteRaceP1;

    /**
     * @param Entity\Player\Basic $character
     * @return $this
     */
    public function setCharacter($character)
    {
        $this->character = $character;
        return $this;
    }

    /**
     * @return Entity\Player\Basic
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * @param string $favoriteRaceP1
     * @return $this
     */
    public function setFavoriteRaceP1($favoriteRaceP1)
    {
        $this->favoriteRaceP1 = $favoriteRaceP1;
        return $this;
    }

    /**
     * @return string
     */
    public function getFavoriteRaceP1()
    {
        return $this->favoriteRaceP1;
    }

    /**
     * @param int $highestRank
     * @return $this
     */
    public function setHighestRank($highestRank)
    {
        $this->highestRank = $highestRank;
        return $this;
    }

    /**
     * @return int
     */
    public function getHighestRank()
    {
        return $this->highestRank;
    }

    /**
     * @param \DateTime $joinDate
     * @return $this
     */
    public function setJoinDate($joinDate)
    {
        $this->joinDate = $joinDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getJoinDate()
    {
        return $this->joinDate;
    }

    /**
     * @param int $losses
     * @return $this
     */
    public function setLosses($losses)
    {
        $this->losses = $losses;
        return $this;
    }

    /**
     * @return int
     */
    public function getLosses()
    {
        return $this->losses;
    }

    /**
     * @param float $points
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;
        return $this;
    }

    /**
     * @return float
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $previousRank
     * @return $this
     */
    public function setPreviousRank($previousRank)
    {
        $this->previousRank = $previousRank;
        return $this;
    }

    /**
     * @return int
     */
    public function getPreviousRank()
    {
        return $this->previousRank;
    }

    /**
     * @param int $wins
     * @return $this
     */
    public function setWins($wins)
    {
        $this->wins = $wins;
        return $this;
    }

    /**
     * @return int
     */
    public function getWins()
    {
        return $this->wins;
    }


}