<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


interface ParsingInterfaceExtensible
{
    /**
     * @param array $params The parameters that should be used for extraction of the API data.
     * @param object $instance An instance that will be used instead of creating a new entry every time.
     * @return object
     */
    public static function extractExtensible($params, $instance);
}