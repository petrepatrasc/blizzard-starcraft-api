<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Reward;

use petrepatrasc\BlizzardApiBundle\Entity\Reward\Decal;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

class DecalParsingService extends ResourceParsingService implements ParsingInterfaceStandalone
{
    /**
     * Extract decal information from an array.
     *
     * @param array $params
     * @return Decal
     */
    public static function extract($params)
    {
        $decal = parent::extractExtensible($params, new Decal());
        return $decal;
    }
}