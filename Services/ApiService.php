<?php

namespace petrepatrasc\BlizzardApiBundle\Services;

use petrepatrasc\BlizzardApiBundle\Entities\Profile;

class ApiService {

    /**
     * Get a player's profile via the Battle.NET API.
     *
     * @param int $battleNetId
     * @param int $realm
     * @param string $playerName
     * @return Profile
     */
    public function getPlayerProfile($battleNetId, $realm, $playerName) {
        $player = new Profile();

        return $player;
    }
}