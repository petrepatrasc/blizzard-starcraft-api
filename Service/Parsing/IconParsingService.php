<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Icon;

class IconParsingService implements ParsingInterfaceStandalone
{

    /**
     * Extract a portrait information from an array.
     *
     * @param array $params
     * @return Icon
     */
    public static function extract($params)
    {
        $portrait = new Icon();
        $portrait->setXCoordinate($params['x'])
            ->setYCoordinate($params['y'])
            ->setWidth($params['w'])
            ->setHeight($params['h'])
            ->setOffset($params['offset'])
            ->setUrl($params['url']);
        return $portrait;
    }
}