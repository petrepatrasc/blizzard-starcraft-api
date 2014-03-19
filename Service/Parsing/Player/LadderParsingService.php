<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Player;


use petrepatrasc\BlizzardApiBundle\Entity\Player\Ladder;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\Season\EntryParsingService;

/**
 * Handles parsing response data from the API.
 * @package petrepatrasc\BlizzardApiBundle\Service\Parsing\Player
 */
class LadderParsingService implements ParsingInterfaceStandalone
{
    /**
     * Extract player ladder information from an array.
     *
     * @param array $params The parameters with the API response where the data should be extracted from.
     * @return Ladder Object containing ladder information.
     */
    public static function extract($params)
    {
        $playerLadder = new Ladder();

        $currentSeasonArray = self::extractCurrentSeasonData($params);
        $previousSeasonArray = self::extractPreviousSeasonData($params);
        $showcasePlacementsArray = self::extractShowcasePlacementData($params);

        $playerLadder->setCurrentSeason($currentSeasonArray)
            ->setPreviousSeason($previousSeasonArray)
            ->setShowcasePlacement($showcasePlacementsArray);

        return $playerLadder;
    }

    /**
     * Extract the current season data into an array of Entries.
     *
     * @param array $params The parameters with the API response where the data should be extracted from.
     * @return array
     */
    public static function extractCurrentSeasonData($params)
    {
        $currentSeasonArray = array();
        foreach ($params['currentSeason'] as $currentSeasonEntry) {
            $currentSeasonArray[] = EntryParsingService::extract($currentSeasonEntry);
        }
        return $currentSeasonArray;
    }

    /**
     * Extract the previous season data into an array of Entries.
     *
     * @param array $params The parameters with the API response where the data should be extracted from.
     * @return array
     */
    public static function extractPreviousSeasonData($params)
    {
        $previousSeasonArray = array();
        foreach ($params['previousSeason'] as $previousSeasonEntry) {
            $previousSeasonArray[] = EntryParsingService::extract($previousSeasonEntry);
        }
        return $previousSeasonArray;
    }

    /**
     * Extract the showcase placement data into an array of Entries.
     *
     * @param array $params The parameters with the API response where the data should be extracted from.
     * @return array
     */
    public static function extractShowcasePlacementData($params)
    {
        $showcasePlacementsArray = array();
        foreach ($params['showcasePlacement'] as $showcasePlacementsEntry) {
            $showcasePlacementsArray[] = EntryParsingService::extract($showcasePlacementsEntry);
        }
        return $showcasePlacementsArray;
    }
}