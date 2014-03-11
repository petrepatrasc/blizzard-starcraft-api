<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Player\Season;
use petrepatrasc\BlizzardApiBundle\Entity\SeasonStats;

class SeasonParsingService implements ParsingInterfaceStandalone
{

    /**
     * Extract season information from an array.
     *
     * @param array $params
     * @return Season
     */
    public static function extract($params)
    {
        $season = new Season();
        $season->setSeasonId($params['seasonId'])
            ->setTotalGamesThisSeason($params['totalGamesThisSeason'])
            ->setSeasonNumber($params['seasonNumber'])
            ->setSeasonYear($params['seasonYear']);

        if (!isset($params['stats'])) {
            return $season;
        }

        foreach ($params['stats'] as $stats) {
            $seasonStats = new SeasonStats();
            $seasonStats->setType($stats['type'])
                ->setWins($stats['wins'])
                ->setGames($stats['games']);
            $season->addSeasonStats($seasonStats);
        }

        return $season;
    }
}