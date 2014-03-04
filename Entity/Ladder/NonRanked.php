<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Ladder;


class NonRanked
{

    /**
     * @var string
     */
    protected $matchMakingQueue;

    /**
     * @var int
     */
    protected $gamesPlayed;

    /**
     * @param int $gamesPlayed
     * @return $this
     */
    public function setGamesPlayed($gamesPlayed)
    {
        $this->gamesPlayed = $gamesPlayed;
        return $this;
    }

    /**
     * @return int
     */
    public function getGamesPlayed()
    {
        return $this->gamesPlayed;
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


}