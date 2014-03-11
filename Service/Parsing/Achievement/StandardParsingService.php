<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Achievement;


use petrepatrasc\BlizzardApiBundle\Entity\Achievement\Standard;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\IconParsingService;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

class StandardParsingService implements ParsingInterfaceStandalone
{

    /**
     * Extract standard achievement information from an array.
     *
     * @param array $params
     * @return Standard
     */
    public static function extract($params)
    {
        $achievement = new Standard();

        $icon = IconParsingService::extract($params['icon']);

        $achievement->setTitle($params['title'])
            ->setDescription($params['description'])
            ->setAchievementId($params['achievementId'])
            ->setCategoryId($params['categoryId'])
            ->setPoints($params['points'])
            ->setIcon($icon);

        return $achievement;
    }
}