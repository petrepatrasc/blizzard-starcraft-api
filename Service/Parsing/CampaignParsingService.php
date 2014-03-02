<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Player\Campaign;

class CampaignParsingService implements ParsingInterface
{
    /**
     * Extract campaign information from an array.
     *
     * @param array $params
     * @return Campaign
     */
    public static function extract($params)
    {
        $campaign = new Campaign();
        $campaign->setWingsOfLibertyStatus($params['wol'])
            ->setHeartOfTheSwarmStatus($params['hots']);
        return $campaign;
    }
}