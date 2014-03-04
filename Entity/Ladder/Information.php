<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Ladder;


class Information
{

    /**
     * @var string
     */
    protected $ladderName;

    /**
     * @var int
     */
    protected $ladderId;

    /**
     * @var int
     */
    protected $division;

    /**
     * @var int
     */
    protected $rank;

    /**
     * @var string
     */
    protected $league;

    /**
     * @var string
     */
    protected $matchMakingQueue;

    /**
     * @var int
     */
    protected $wins;

    /**
     * @var int
     */
    protected $losses;

    /**
     * @var bool
     */
    protected $showcase;

    /**
     * @param int $division
     * @return $this
     */
    public function setDivision($division)
    {
        $this->division = $division;
        return $this;
    }

    /**
     * @return int
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * @param int $ladderId
     * @return $this
     */
    public function setLadderId($ladderId)
    {
        $this->ladderId = $ladderId;
        return $this;
    }

    /**
     * @return int
     */
    public function getLadderId()
    {
        return $this->ladderId;
    }

    /**
     * @param string $ladderName
     * @return $this
     */
    public function setLadderName($ladderName)
    {
        $this->ladderName = $ladderName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLadderName()
    {
        return $this->ladderName;
    }

    /**
     * @param string $league
     * @return $this
     */
    public function setLeague($league)
    {
        $this->league = $league;
        return $this;
    }

    /**
     * @return string
     */
    public function getLeague()
    {
        return $this->league;
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
     * @param string $matchMakingQueue
     * @return $this
     */
    public function setMatchMakingQueue($matchMakingQueue)
    {
        $this->matchMakingQueue = $matchMakingQueue;
        return $this;
    }

    /**
     * @return string
     */
    public function getMatchMakingQueue()
    {
        return $this->matchMakingQueue;
    }

    /**
     * @param int $rank
     * @return $this
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
        return $this;
    }

    /**
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param boolean $showcase
     * @return $this
     */
    public function setShowcase($showcase)
    {
        $this->showcase = $showcase;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getShowcase()
    {
        return $this->showcase;
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