<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\Player\SwarmLevels;
use petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel;

class SwarmLevelsParsingService implements ParsingInterfaceStandalone
{
    /**
     * Extract swarm level information from an array.
     *
     * @param array $params
     * @return SwarmLevels
     */
    public static function extract($params)
    {
        $terranSwarmLevel = new SwarmLevel();
        $terranSwarmLevel->setLevel($params['terran']['level'])
            ->setTotalLevelXp($params['terran']['totalLevelXP'])
            ->setCurrentLevelXp($params['terran']['currentLevelXP']);

        $protossSwarmLevel = new SwarmLevel();
        $protossSwarmLevel->setLevel($params['protoss']['level'])
            ->setTotalLevelXp($params['protoss']['totalLevelXP'])
            ->setCurrentLevelXp($params['protoss']['currentLevelXP']);

        $zergSwarmLevel = new SwarmLevel();
        $zergSwarmLevel->setLevel($params['zerg']['level'])
            ->setTotalLevelXp($params['zerg']['totalLevelXP'])
            ->setCurrentLevelXp($params['zerg']['currentLevelXP']);

        $playerSwarmLevels = new SwarmLevels();
        $playerSwarmLevels->setPlayerLevel($params['level'])
            ->setTerranLevel($terranSwarmLevel)
            ->setProtossLevel($protossSwarmLevel)
            ->setZergLevel($zergSwarmLevel);
        return $playerSwarmLevels;
    }
}