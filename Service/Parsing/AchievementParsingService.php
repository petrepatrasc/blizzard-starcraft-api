<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Achievement\Points;
use petrepatrasc\BlizzardApiBundle\Entity\Achievement;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Achievements;

class AchievementParsingService implements ParsingInterface
{

    /**
     * Extract achievement information from an array.
     *
     * @param array $params
     * @return Achievements
     */
    public static function extract($params)
    {
        $points = new Points();
        $points->setTotalPoints($params['points']['totalPoints'])
            ->setCategoryPoints($params['points']['categoryPoints']);

        $achievements = new Achievements();
        $achievements->setPoints($points);

        foreach ($params['achievements'] as $achievementEntry) {
            $completionDate = new \DateTime();
            $completionDate->setTimestamp($achievementEntry['completionDate']);

            $achievementEntity = new Achievement();
            $achievementEntity->setAchievementId($achievementEntry['achievementId'])
                ->setCompletionDate($completionDate);

            $achievements->addAchievements($achievementEntity);
        }
        return $achievements;
    }
}