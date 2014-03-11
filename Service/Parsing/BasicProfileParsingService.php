<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Player\Basic;

class BasicProfileParsingService implements ParsingInterfaceStandalone
{

    /**
     * Extract a basic profile information structure from an array.
     *
     * @param array $params
     * @return Basic
     */
    public static function extract($params)
    {
        $profileBasicInformation = new Basic();
        $profileBasicInformation->setId($params['id'])
            ->setRealm($params['realm'])
            ->setDisplayName($params['displayName'])
            ->setClanName($params['clanName'])
            ->setClanTag($params['clanTag'])
            ->setProfilePath($params['profilePath']);
        return $profileBasicInformation;
    }
}