<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Ladder;


use petrepatrasc\BlizzardApiBundle\Entity\Ladder\Position;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\BasicProfileParsingService;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

/**
 * Handle parsing ladder positions entries as retrieved from the API.
 * @package petrepatrasc\BlizzardApiBundle\Service\Parsing\Ladder
 */
class PositionParsingService implements ParsingInterfaceStandalone
{

    /**
     * Extract ladder position entry from an array.
     *
     * @param array $params
     * @return Position
     */
    public static function extract($params)
    {
        $ladderPosition = new Position();
        $characterProfile = BasicProfileParsingService::extract($params['character']);

        $joinDate = new \DateTime();
        $joinDate->setTimestamp($params['joinTimestamp']);

        if (!isset($params['favoriteRaceP1'])) {
            $params['favoriteRaceP1'] = null;
        }

        $ladderPosition->setCharacter($characterProfile)
            ->setJoinDate($joinDate)
            ->setPoints($params['points'])
            ->setWins($params['wins'])
            ->setLosses($params['losses'])
            ->setHighestRank($params['highestRank'])
            ->setPreviousRank($params['previousRank'])
            ->setFavoriteRaceP1($params['favoriteRaceP1']);

        return $ladderPosition;
    }
}