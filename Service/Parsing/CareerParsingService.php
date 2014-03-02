<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Player\Career;

class CareerParsingService implements ParsingInterface
{
    /**
     * Extract career information from an array.
     *
     * @param array $params
     * @return Career
     */
    public static function extract($params)
    {
        $career = new Career();
        $career->setPrimaryRace($params['primaryRace'])
            ->setLeague($params['league'])
            ->setTerranWins($params['terranWins'])
            ->setProtossWins($params['protossWins'])
            ->setZergWins($params['zergWins'])
            ->setHighest1v1Rank($params['highest1v1Rank'])
            ->setHighestTeamRank($params['highestTeamRank'])
            ->setSeasonTotalGames($params['seasonTotalGames'])
            ->setCareerTotalGames($params['careerTotalGames']);
        return $career;
    }
}