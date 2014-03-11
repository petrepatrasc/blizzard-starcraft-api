<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Achievement;


use petrepatrasc\BlizzardApiBundle\Entity\Achievement\Information;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

class InformationParsingService implements ParsingInterfaceStandalone
{
    /**
     * Extract achievement information from an array.
     *
     * @param array $params
     * @return Information
     */
    public static function extract($params)
    {
        $information = new Information();

        $achievements = self::extractAchievements($params);
        $information->setAchievements($achievements);
        unset($achievements);

        $categories = self::extractCategories($params);
        $information->setCategories($categories);
        unset($categories);

        return $information;
    }

    /**
     * @param $params
     * @return array
     */
    protected static function extractAchievements($params)
    {
        $achievements = array();
        foreach ($params['achievements'] as $achievement) {
            $achievements[] = StandardParsingService::extract($achievement);
        }
        return $achievements;
    }

    /**
     * @param $params
     * @return array
     */
    protected static function extractCategories($params)
    {
        $categories = array();
        foreach ($params['categories'] as $category) {
            $categories[] = CategoryParsingService::extract($category);
        }
        return $categories;
    }
}