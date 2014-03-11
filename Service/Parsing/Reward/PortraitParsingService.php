<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Reward;

use petrepatrasc\BlizzardApiBundle\Entity\Reward\Portrait;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

class PortraitParsingService extends ResourceParsingService implements ParsingInterfaceStandalone
{
    /**
     * Extract portrait information from an array.
     *
     * @param array $params
     * @return Portrait
     */
    public static function extract($params)
    {
        $decal = parent::extractExtensible($params, new Portrait());
        return $decal;
    }
}