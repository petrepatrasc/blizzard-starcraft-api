<?php

namespace petrepatrasc\BlizzardApiBundle\Service;


class NormalisationService
{

    /**
     * Get a normalised player profile.
     *
     * @return array
     */
    public static function getNormalisedPlayerProfile()
    {
        return array(
            'id' => null,
            'realm' => null,
            'displayName' => null,
            'clanName' => null,
            'clanTag' => null,
            'profilePath' => null,
            'portrait' => array(
                'x' => null,
                'y' => null,
                'w' => null,
                'h' => null,
                'offset' => null,
                'url' => null
            ),
            'career' => array(
                'primaryRace' => null,
                'league' => null,
                'terranWins' => null,
                'protossWins' => null,
                'zergWins' => null,
                'highest1v1Rank' => null,
                'highestTeamRank' => null,
                'seasonTotalGames' => null,
                'careerTotalGames' => null
            ),
            'swarmLevels' => array(
                'level' => null,
                'terran' => array(
                    'level' => null,
                    'totalLevelXP' => null,
                    'currentLevelXP' => null
                ),
                'zerg' => array(
                    'level' => null,
                    'totalLevelXP' => null,
                    'currentLevelXP' => null
                ),
                'protoss' => array(
                    'level' => null,
                    'totalLevelXP' => null,
                    'currentLevelXP' => null
                )
            ),
            'campaign' => array(
                'wol' => null,
                'hots' => null
            ),
            'season' => array(
                'seasonId' => null,
                'totalGamesThisSeason' => null,
                'stats' => array(),
                'seasonNumber' => null,
                'seasonYear' => null
            ),
            'rewards' => array(
                'selected' => array(),
                'earned' => array()
            ),
            'achievements' => array(
                'points' => array(
                    'totalPoints' => null,
                    'categoryPoints' => array(
                        '4325382' => null,
                        '4325380' => null,
                        '4325408' => null,
                        '4325379' => null,
                        '4325410' => null,
                        '4325377' => null
                    )
                ),
                'achievements' => array()
            )
        );
    }
}