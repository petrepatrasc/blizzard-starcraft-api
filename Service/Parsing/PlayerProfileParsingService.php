<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Player;

class PlayerProfileParsingService implements ParsingInterface
{
    /**
     * Extract complete player profile information from an array.
     *
     * @param array $params
     * @return Player
     */
    public static function extract($params)
    {
        $portrait = PortraitParsingService::extract($params['portrait']);
        $career = CareerParsingService::extract($params['career']);
        $playerSwarmLevels = SwarmLevelsParsingService::extract($params['swarmLevels']);
        $campaign = CampaignParsingService::extract($params['campaign']);
        $season = SeasonParsingService::extract($params['season']);
        $rewards = RewardsParsingService::extract($params['rewards']);
        $achievements = AchievementParsingService::extract($params['achievements']);
        $profileBasicInformation = BasicProfileParsingService::extract($params);

        $player = new Player();
        $player->setBasicInformation($profileBasicInformation)
            ->setPortrait($portrait)
            ->setCareer($career)
            ->setSwarmLevels($playerSwarmLevels)
            ->setCampaign($campaign)
            ->setSeason($season)
            ->setRewards($rewards)
            ->setAchievements($achievements);
        return $player;
    }
}