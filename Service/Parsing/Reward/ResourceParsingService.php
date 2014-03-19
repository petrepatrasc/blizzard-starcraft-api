<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Reward;

use petrepatrasc\BlizzardApiBundle\Entity;
use petrepatrasc\BlizzardApiBundle\Service\Parsing;

/**
 * Handles the parsing of reward resources entities, and offers functionality for children that inherit from
 * parent Resource objects.
 * @package petrepatrasc\BlizzardApiBundle\Service\Parsing\Reward
 */
class ResourceParsingService implements Parsing\ParsingInterfaceExtensible
{
    /**
     * Extract generic resource information from an array.
     *
     * @param array $params
     * @param Entity\Reward\Resource $instance
     * @return Entity\Reward\Resource
     */
    public static function extractExtensible($params, $instance)
    {
        $icon = Parsing\IconParsingService::extract($params['icon']);

        if (is_null($instance)) {
            $instance = new Entity\Reward\Resource();
        }

        $instance->setTitle($params['title'])
            ->setId($params['id'])
            ->setIcon($icon)
            ->setAchievementId($params['achievementId']);

        return $instance;
    }
}