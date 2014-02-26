<?php

namespace petrepatrasc\BlizzardApiBundle\Service;

use petrepatrasc\BlizzardApiBundle\Entity\Player;

class ApiService
{
    const API_PROFILE_METHOD = '/api/sc2/profile/';

    /**
     * @var CallService
     */
    protected $callService = null;

    /**
     * @param $callService
     */
    public function __construct($callService)
    {
        $this->callService = $callService;
    }

    /**
     * Get a player's profile via the Battle.NET API.
     *
     * @param string $locale
     * @param int $battleNetId
     * @param int $realm
     * @param string $playerName
     * @return Player
     */
    public function getPlayerProfile($locale, $battleNetId, $playerName, $realm = 1)
    {
        $apiParameters = array($battleNetId, $realm, $playerName);
        $apiData = $this->makeCall($locale, self::API_PROFILE_METHOD, $apiParameters);

        $player = new Player();
        $player->setId($apiData['id'])
            ->setRealm($apiData['realm'])
            ->setDisplayName($apiData['displayName'])
            ->setClanName($apiData['clanName'])
            ->setClanTag($apiData['clanTag'])
            ->setProfilePath($apiData['profilePath']);

        var_dump($player);

        return $player;
    }

    public function makeCall($locale, $apiMethod, $params = array()) {
        return json_decode($this->callService->makeCallToApiService($locale, $apiMethod, $params), true);
    }
}