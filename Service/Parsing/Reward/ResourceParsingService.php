<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Reward;

use petrepatrasc\BlizzardApiBundle\Entity\Reward\Resource;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\IconParsingService;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceExtensible;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

class ResourceParsingService implements ParsingInterfaceExtensible
{
    /**
     * Extract generic resource information from an array.
     *
     * @param array $params
     * @param null $instance
     * @return \stdClass
     */
    public static function extractExtensible($params, $instance = null)
    {
        $icon = IconParsingService::extract($params['icon']);

        if (is_null($instance)) {
            $instance = new Resource();
        }

        $instance->setTitle($params['title'])
            ->setId($params['id'])
            ->setIcon($icon)
            ->setAchievementId($params['achievementId']);

        return $instance;
    }
}