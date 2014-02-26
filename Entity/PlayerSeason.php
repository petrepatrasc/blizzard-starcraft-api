<?php

namespace petrepatrasc\BlizzardApiBundle\Entity;


class PlayerSeason
{

    /**
     * @var int
     */
    protected $seasonId;

    /**
     * @var int
     */
    protected $totalGamesThisSeason;

    /**
     * @var array
     */
    protected $stats = array();

    /**
     * @var int
     */
    protected $seasonNumber;

    /**
     * @var int
     */
    protected $seasonYear;

    /**
     * @param int $seasonId
     * @return $this
     */
    public function setSeasonId($seasonId)
    {
        $this->seasonId = $seasonId;
        return $this;
    }

    /**
     * @return int
     */
    public function getSeasonId()
    {
        return $this->seasonId;
    }

    /**
     * @param int $seasonNumber
     * @return $this
     */
    public function setSeasonNumber($seasonNumber)
    {
        $this->seasonNumber = $seasonNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getSeasonNumber()
    {
        return $this->seasonNumber;
    }

    /**
     * @param int $seasonYear
     * @return $this
     */
    public function setSeasonYear($seasonYear)
    {
        $this->seasonYear = $seasonYear;
        return $this;
    }

    /**
     * @return int
     */
    public function getSeasonYear()
    {
        return $this->seasonYear;
    }

    /**
     * @param array $stats
     * @return $this
     */
    public function setStats($stats)
    {
        $this->stats = $stats;
        return $this;
    }

    /**
     * @return array
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @param int $totalGamesThisSeason
     * @return $this
     */
    public function setTotalGamesThisSeason($totalGamesThisSeason)
    {
        $this->totalGamesThisSeason = $totalGamesThisSeason;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalGamesThisSeason()
    {
        return $this->totalGamesThisSeason;
    }

    /**
     * @param SeasonStats $stats
     * @return $this
     */
    public function addSeasonStats(SeasonStats $stats)
    {
        $this->stats[] = $stats;
        return $this;
    }
}