<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Achievement\Points;
use petrepatrasc\BlizzardApiBundle\Entity\Achievement;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Achievements;

/**
 * Handles parsing achievements from API data.
 * @package petrepatrasc\BlizzardApiBundle\Service\Parsing
 */
class AchievementParsingService implements ParsingInterfaceStandalone
{

    /**
     * Extract achievement information from an array.
     *
     * @param array $params The parameters with the API response where the data should be extracted from.
     * @return Achievements
     */
    public static function extract($params)
    {
        $points = self::extractAchievementPointsData($params);

        $achievementsWrapper = self::extractAchievementEntitiesData($params);

        $achievements = new Achievements();
        $achievements->setPoints($points);
        $achievements->setAchievements($achievementsWrapper);
        return $achievements;
    }

    /**
     * Extract an array of achievement Entities from the API data.
     *
     * @param array $params The parameters with the API response where the data should be extracted from.
     * @return array
     */
    public static function extractAchievementEntitiesData($params)
    {
        $achievementsWrapper = array();
        foreach ($params['achievements'] as $achievementEntry) {
            $completionDate = new \DateTime();
            $completionDate->setTimestamp($achievementEntry['completionDate']);

            $achievementEntity = new Achievement();
            $achievementEntity->setAchievementId($achievementEntry['achievementId'])
                ->setCompletionDate($completionDate);

            $achievementsWrapper[] = $achievementEntity;
        }
        return $achievementsWrapper;
    }

    /**
     * Extract achievement points from the API response.
     *
     * @param array $params The parameters with the API response where the data should be extracted from.
     * @return Points
     */
    public static function extractAchievementPointsData($params)
    {
        $points = new Points();
        $points->setTotalPoints($params['points']['totalPoints'])
            ->setCategoryPoints($params['points']['categoryPoints']);
        return $points;
    }
}