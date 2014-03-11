<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Ladder;


use petrepatrasc\BlizzardApiBundle\Entity\Ladder\NonRanked;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

class NonRankedParsingService implements ParsingInterfaceStandalone
{
    /**
     * Extract non ranked information from an array.
     *
     * @param array $params
     * @return NonRanked
     */
    public static function extract($params)
    {
        $nonRanked = new NonRanked();
        $nonRanked->setMatchMakingQueue($params['mmq'])
            ->setGamesPlayed($params['gamesPlayed']);

        return $nonRanked;
    }
}