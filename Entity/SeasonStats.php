<?php

namespace petrepatrasc\BlizzardApiBundle\Entity;


class SeasonStats
{

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $wins;

    /**
     * @var int
     */
    protected $games;

    /**
     * @param int $games
     * @return $this
     */
    public function setGames($games)
    {
        $this->games = $games;
        return $this;
    }

    /**
     * @return int
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
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