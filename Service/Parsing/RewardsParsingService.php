<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Player\Rewards;

class RewardsParsingService implements ParsingInterface
{

    /**
     * Extract rewards information from an array.
     *
     * @param array $params
     * @return Rewards
     */
    public static function extract($params)
    {
        $rewards = new Rewards();
        $rewards->setSelected($params['selected'])
            ->setEarned($params['earned']);
        return $rewards;
    }
}