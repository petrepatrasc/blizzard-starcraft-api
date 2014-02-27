<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Player;


class Career
{

    /**
     * @var string
     */
    protected $primaryRace;

    /**
     * @var string
     */
    protected $league;

    /**
     * @var int
     */
    protected $terranWins;

    /**
     * @var int
     */
    protected $protossWins;

    /**
     * @var int
     */
    protected $zergWins;

    /**
     * @var string
     */
    protected $highest1v1Rank;

    /**
     * @var string
     */
    protected $highestTeamRank;

    /**
     * @var int
     */
    protected $seasonTotalGames;

    /**
     * @var int
     */
    protected $careerTotalGames;

    /**
     * @param int $careerTotalGames
     * @return $this
     */
    public function setCareerTotalGames($careerTotalGames)
    {
        $this->careerTotalGames = $careerTotalGames;
        return $this;
    }

    /**
     * @return int
     */
    public function getCareerTotalGames()
    {
        return $this->careerTotalGames;
    }

    /**
     * @param string $highest1v1Rank
     * @return $this
     */
    public function setHighest1v1Rank($highest1v1Rank)
    {
        $this->highest1v1Rank = $highest1v1Rank;
        return $this;
    }

    /**
     * @return string
     */
    public function getHighest1v1Rank()
    {
        return $this->highest1v1Rank;
    }

    /**
     * @param string $highestTeamRank
     * @return $this
     */
    public function setHighestTeamRank($highestTeamRank)
    {
        $this->highestTeamRank = $highestTeamRank;
        return $this;
    }

    /**
     * @return string
     */
    public function getHighestTeamRank()
    {
        return $this->highestTeamRank;
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
     * @param string $primaryRace
     * @return $this
     */
    public function setPrimaryRace($primaryRace)
    {
        $this->primaryRace = $primaryRace;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrimaryRace()
    {
        return $this->primaryRace;
    }

    /**
     * @param int $protossWins
     * @return $this
     */
    public function setProtossWins($protossWins)
    {
        $this->protossWins = $protossWins;
        return $this;
    }

    /**
     * @return int
     */
    public function getProtossWins()
    {
        return $this->protossWins;
    }

    /**
     * @param int $seasonTotalGames
     * @return $this
     */
    public function setSeasonTotalGames($seasonTotalGames)
    {
        $this->seasonTotalGames = $seasonTotalGames;
        return $this;
    }

    /**
     * @return int
     */
    public function getSeasonTotalGames()
    {
        return $this->seasonTotalGames;
    }

    /**
     * @param int $terranWins
     * @return $this
     */
    public function setTerranWins($terranWins)
    {
        $this->terranWins = $terranWins;
        return $this;
    }

    /**
     * @return int
     */
    public function getTerranWins()
    {
        return $this->terranWins;
    }

    /**
     * @param int $zergWins
     * @return $this
     */
    public function setZergWins($zergWins)
    {
        $this->zergWins = $zergWins;
        return $this;
    }

    /**
     * @return int
     */
    public function getZergWins()
    {
        return $this->zergWins;
    }


}