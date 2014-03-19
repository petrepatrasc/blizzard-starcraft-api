<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Player\Season;
use petrepatrasc\BlizzardApiBundle\Entity\SeasonStats;

/**
 * Handles parsing season entities from the response of the API.
 * @package petrepatrasc\BlizzardApiBundle\Service\Parsing
 */
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

        $statsWrapper = self::extractSeasonStatsData($params);
        $season->setStats($statsWrapper);

        return $season;
    }

    /**
     * Extract season stat data from the API response.
     *
     * @param array $params
     * @return array
     */
    public static function extractSeasonStatsData($params)
    {
        $statsWrapper = array();
        foreach ($params['stats'] as $stats) {
            $seasonStats = new SeasonStats();
            $seasonStats->setType($stats['type'])
                ->setWins($stats['wins'])
                ->setGames($stats['games']);

            $statsWrapper[] = $seasonStats;
        }
        return $statsWrapper;
    }
}