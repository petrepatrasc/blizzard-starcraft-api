<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Reward;

use petrepatrasc\BlizzardApiBundle\Entity\Reward\Animation;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

class AnimationParsingService extends ResourceParsingService implements ParsingInterfaceStandalone
{
    /**
     * Extract animation information from an array.
     *
     * @param array $params
     * @internal $animation Animation
     * @return Animation
     */
    public static function extract($params)
    {
        $animation = parent::extractExtensible($params, new Animation());

        /**
         * @var $animation Animation
         */
        $animation->setCommand(isset($params['command']) ? $params['command'] : null);

        return $animation;
    }
}