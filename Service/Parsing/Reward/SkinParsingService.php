<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Reward;


use petrepatrasc\BlizzardApiBundle\Entity\Reward\Skin;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

class SkinParsingService extends ResourceParsingService implements ParsingInterfaceStandalone
{
    /**
     * Extract skin information from an array.
     *
     * @param array $params
     * @return Skin
     */
    public static function extract($params)
    {
        $skin = parent::extractExtensible($params, new Skin());

        /**
         * @var $skin Skin
         */
        $skin->setName($params['name']);

        return $skin;
    }
}