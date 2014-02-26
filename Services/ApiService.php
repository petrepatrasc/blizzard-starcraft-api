<?php

namespace petrepatrasc\BlizzardApiBundle\Services;

use petrepatrasc\BlizzardApiBundle\Entities\Player;

class ApiService
{

    /**
     * Get a player's profile via the Battle.NET API.
     *
     * @param int $battleNetId
     * @param int $realm
     * @param string $playerName
     * @return Player
     */
    public function getPlayerProfile($battleNetId, $realm, $playerName)
    {
        $player = new Player();

        return $player;
    }
}