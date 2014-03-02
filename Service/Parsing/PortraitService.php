<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Player\Portrait;

class PortraitService implements ParsingInterface
{

    /**
     * Extract a portrait information from an array.
     *
     * @param array $params
     * @return Portrait
     */
    public static function extract($params)
    {
        $portrait = new Portrait();
        $portrait->setXCoordinate($params['x'])
            ->setYCoordinate($params['y'])
            ->setWidth($params['w'])
            ->setHeight($params['h'])
            ->setOffset($params['offset'])
            ->setUrl($params['url']);
        return $portrait;
    }
}