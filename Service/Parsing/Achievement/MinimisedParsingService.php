<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Achievement;


use petrepatrasc\BlizzardApiBundle\Entity\Achievement\Minimised;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

class MinimisedParsingService implements ParsingInterfaceStandalone
{
    /**
     * Extract minimised achievement information from an array.
     *
     * @param array $params
     * @return Minimised
     */
    public static function extract($params)
    {
        $achievement = new Minimised();

        $achievement->setTitle($params['title'])
            ->setCategoryId($params['categoryId'])
            ->setFeaturedAchievementId($params['featuredAchievementId']);

        return $achievement;
    }
}