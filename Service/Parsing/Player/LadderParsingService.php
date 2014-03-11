<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Player;


use petrepatrasc\BlizzardApiBundle\Entity\Player\Ladder;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\Season\EntryParsingService;

class LadderParsingService implements ParsingInterfaceStandalone
{
    /**
     * Extract player ladder information from an array.
     *
     * @param array $params
     * @return Ladder
     */
    public static function extract($params)
    {
        $playerLadder = new Ladder();

        $currentSeasonArray = array();
        foreach ($params['currentSeason'] as $currentSeasonEntry) {
            $currentSeasonArray[] = EntryParsingService::extract($currentSeasonEntry);
        }

        $previousSeasonArray = array();
        foreach ($params['previousSeason'] as $previousSeasonEntry) {
            $previousSeasonArray[] = EntryParsingService::extract($previousSeasonEntry);
        }

        $showcasePlacementsArray = array();
        foreach ($params['showcasePlacement'] as $showcasePlacementsEntry) {
            $showcasePlacementsArray[] = EntryParsingService::extract($showcasePlacementsEntry);
        }

        $playerLadder->setCurrentSeason($currentSeasonArray)
            ->setPreviousSeason($previousSeasonArray)
            ->setShowcasePlacement($showcasePlacementsArray);

        return $playerLadder;
    }
}