<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Season;


use petrepatrasc\BlizzardApiBundle\Entity\Season\Entry;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\BasicProfileParsingService;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\Ladder\InformationParsingService;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\Ladder\NonRankedParsingService;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterface;

class EntryParsingService implements ParsingInterface
{

    /**
     * Extract season entry information from an array.
     *
     * @param array $params
     * @return Entry
     */
    public static function extract($params)
    {
        $seasonEntry = new Entry();

        $ladderInformationArray = array();
        foreach ($params['ladder'] as $ladderInformationEntry) {
            $ladderInformationArray[] = InformationParsingService::extract($ladderInformationEntry);
        }

        $characters = array();
        foreach ($params['characters'] as $character) {
            $characters[] = BasicProfileParsingService::extract($character);
        }

        $nonRankedArray = array();
        foreach ($params['nonRanked'] as $nonRankedEntry) {
            $nonRankedArray[] = NonRankedParsingService::extract($nonRankedEntry);
        }

        $seasonEntry->setLadderInformation($ladderInformationArray)
            ->setCharacters($characters)
            ->setNonRanked($nonRankedArray);

        return $seasonEntry;
    }
}