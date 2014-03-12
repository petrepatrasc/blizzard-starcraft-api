<?php

namespace petrepatrasc\BlizzardApiBundle\Service;


class NormalisationService
{

    /**
     * Return a normalised Icon array.
     *
     * @return array
     */
    public static function getNormalisedIcon() {
        return array(
            'x' => null,
            'y' => null,
            'w' => null,
            'h' => null,
            'offset' => null,
            'url' => null
        );
    }

    /**
     * Get a normalised player career array.
     *
     * @return array
     */
    public static function getNormalisedPlayerCareer() {
        return array(
            'primaryRace' => null,
            'league' => null,
            'terranWins' => null,
            'protossWins' => null,
            'zergWins' => null,
            'highest1v1Rank' => null,
            'highestTeamRank' => null,
            'seasonTotalGames' => null,
            'careerTotalGames' => null
        );
    }

    /**
     * Get a normalised player swarm levels array.
     *
     * @return array
     */
    public static function getNormalisedPlayerSwarmLevels() {
        return array(
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
        );
    }

    /**
     * Get a normalised player achievements array.
     *
     * @return array
     */
    public static function getNormalisedPlayerAchievements() {
        return array(
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
        );
    }

    /**
     * Get a normalised player rewards array.
     *
     * @return array
     */
    public function getNormalisedPlayerRewards() {
        return array(
            'selected' => array(),
            'earned' => array()
        );
    }

    /**
     * Get a normalised player season array.
     *
     * @return array
     */
    public static function getNormalisedPlayerSeason() {
        return array(
            'seasonId' => null,
            'totalGamesThisSeason' => null,
            'stats' => array(),
            'seasonNumber' => null,
            'seasonYear' => null
        );
    }

    /**
     * Get a normalised player campaign array.
     *
     * @return array
     */
    public static function getNormalisedPlayerCampaign() {
        return array(
            'wol' => null,
            'hots' => null
        );
    }

    /**
     * Get a normalised player profile array.
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
            'portrait' => self::getNormalisedIcon(),
            'career' => self::getNormalisedPlayerCareer(),
            'swarmLevels' => self::getNormalisedPlayerSwarmLevels(),
            'campaign' => self::getNormalisedPlayerCampaign(),
            'season' => self::getNormalisedPlayerSeason(),
            'rewards' => self::getNormalisedPlayerRewards(),
            'achievements' => self::getNormalisedPlayerAchievements()
        );
    }
}