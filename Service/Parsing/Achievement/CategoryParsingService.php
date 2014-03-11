<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Achievement;


use petrepatrasc\BlizzardApiBundle\Entity\Achievement\Category;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

class CategoryParsingService implements ParsingInterfaceStandalone
{
    /**
     * Extract achievement category information from an array.
     *
     * @param array $params
     * @return Category
     */
    public static function extract($params)
    {
        $category = new Category();

        $minimised = MinimisedParsingService::extract($params);
        $category->setMinimisedAchievement($minimised);

        if (isset($params['children'])) {
            $minimisedAchievements = array();
            foreach ($params['children'] as $child) {
                $minimisedAchievements[] = MinimisedParsingService::extract($child);
            }
            $category->setChildren($minimisedAchievements);
        }

        return $category;
    }
}