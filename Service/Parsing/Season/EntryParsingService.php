<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Season;


use petrepatrasc\BlizzardApiBundle\Entity\Season\Entry;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\BasicProfileParsingService;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\Ladder\InformationParsingService;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\Ladder\NonRankedParsingService;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

/**
 * Handles parsing season entry data from the API.
 * @package petrepatrasc\BlizzardApiBundle\Service\Parsing\Season
 */
class EntryParsingService implements ParsingInterfaceStandalone
{

    /**
     * Extract season entry information from an array.
     *
     * @param array $params The parameters with the API response where the data should be extracted from.
     * @return Object containing season information.
     */
    public static function extract($params)
    {
        $seasonEntry = new Entry();

        $ladderInformationArray = self::extractLadderInformationData($params);
        $characters = self::extractCharacterData($params);
        $nonRankedArray = self::extractNonRankedLadderData($params);

        $seasonEntry->setLadderInformation($ladderInformationArray)
            ->setCharacters($characters)
            ->setNonRanked($nonRankedArray);

        return $seasonEntry;
    }

    /**
     * Extract ladder information from an array.
     *
     * @param array $params The parameters with the API response where the data should be extracted from.
     * @return array
     */
    public static function extractLadderInformationData($params)
    {
        $ladderInformationArray = array();
        foreach ($params['ladder'] as $ladderInformationEntry) {
            $ladderInformationArray[] = InformationParsingService::extract($ladderInformationEntry);
        }
        return $ladderInformationArray;
    }

    /**
     * Extract basic profile data from an array.
     *
     * @param array $params The parameters with the API response where the data should be extracted from.
     * @return array
     */
    public static function extractCharacterData($params)
    {
        $characters = array();
        foreach ($params['characters'] as $character) {
            $characters[] = BasicProfileParsingService::extract($character);
        }
        return $characters;
    }

    /**
     * Extract non-ranked ladder information from an array.
     *
     * @param array $params The parameters with the API response where the data should be extracted from.
     * @return array
     */
    public static function extractNonRankedLadderData($params)
    {
        $nonRankedArray = array();
        foreach ($params['nonRanked'] as $nonRankedEntry) {
            $nonRankedArray[] = NonRankedParsingService::extract($nonRankedEntry);
        }
        return $nonRankedArray;
    }
}