<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Ladder;


use petrepatrasc\BlizzardApiBundle\Entity\Ladder\Information;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterface;

class InformationParsingService implements ParsingInterface
{
    /**
     * Extract ladder information from an array.
     *
     * @param array $params
     * @return Information
     */
    public static function extract($params)
    {
        $ladderInformation = new Information();
        $ladderInformation->setLadderName($params['ladderName'])
            ->setLadderId($params['ladderId'])
            ->setDivision($params['division'])
            ->setRank($params['rank'])
            ->setLeague($params['league'])
            ->setMatchMakingQueue($params['matchMakingQueue'])
            ->setWins($params['wins'])
            ->setLosses($params['losses'])
            ->setShowcase($params['showcase']);

        return $ladderInformation;
    }
}