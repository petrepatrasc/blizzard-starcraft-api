<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Match;

class MatchParsingService implements ParsingInterface
{
    /**
     * Extract campaign information from an array.
     *
     * @param array $params
     * @return Match
     */
    public static function extract($params)
    {
        $matchDate = new \DateTime();
        $matchDate->setTimestamp($params['date']);

        $match = new Match();
        $match->setMap($params['map'])
            ->setType($params['type'])
            ->setDecision($params['decision'])
            ->setSpeed($params['speed'])
            ->setDate($matchDate);

        return $match;
    }
}