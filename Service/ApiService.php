<?php

namespace petrepatrasc\BlizzardApiBundle\Service;

use petrepatrasc\BlizzardApiBundle\Entity\Player;
use petrepatrasc\BlizzardApiBundle\Entity\PlayerCareer;
use petrepatrasc\BlizzardApiBundle\Entity\PlayerPortrait;
use petrepatrasc\BlizzardApiBundle\Entity\PlayerSwarmLevels;
use petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel;

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

        $portrait = $this->extractPlayerPortraitFromProfileData($apiData);
        $career = $this->extractPlayerCareerFromProfileData($apiData);
        $playerSwarmLevels = $this->extractPlayerSwarmLevelsFromProfileData($apiData);

        $player = new Player();
        $player->setId($apiData['id'])
            ->setRealm($apiData['realm'])
            ->setDisplayName($apiData['displayName'])
            ->setClanName($apiData['clanName'])
            ->setClanTag($apiData['clanTag'])
            ->setProfilePath($apiData['profilePath'])
            ->setPortrait($portrait)
            ->setCareer($career)
            ->setSwarmLevels($playerSwarmLevels);

        return $player;
    }

    public function makeCall($locale, $apiMethod, $params = array())
    {
        return json_decode($this->callService->makeCallToApiService($locale, $apiMethod, $params), true);
    }

    /**
     * @param $apiData
     * @return PlayerPortrait
     */
    protected function extractPlayerPortraitFromProfileData($apiData)
    {
        $portrait = new PlayerPortrait();
        $portrait->setXCoordinate(isset($apiData['portrait']['x']) ? $apiData['portrait']['x'] : null)
            ->setYCoordinate(isset($apiData['portrait']['y']) ? $apiData['portrait']['y'] : null)
            ->setWidth(isset($apiData['portrait']['w']) ? $apiData['portrait']['w'] : null)
            ->setHeight(isset($apiData['portrait']['h']) ? $apiData['portrait']['h'] : null)
            ->setOffset(isset($apiData['portrait']['offset']) ? $apiData['portrait']['offset'] : null)
            ->setUrl(isset($apiData['portrait']['url']) ? $apiData['portrait']['url'] : null);
        return $portrait;
    }

    /**
     * @param $apiData
     * @return PlayerCareer
     */
    protected function extractPlayerCareerFromProfileData($apiData)
    {
        $career = new PlayerCareer();
        $career->setPrimaryRace(isset($apiData['career']['primaryRace']) ? $apiData['career']['primaryRace'] : null)
            ->setLeague(isset($apiData['career']['league']) ? $apiData['career']['league'] : null)
            ->setTerranWins(isset($apiData['career']['terranWins']) ? $apiData['career']['terranWins'] : null)
            ->setProtossWins(isset($apiData['career']['protossWins']) ? $apiData['career']['protossWins'] : null)
            ->setZergWins(isset($apiData['career']['zergWins']) ? $apiData['career']['zergWins'] : null)
            ->setHighest1v1Rank(isset($apiData['career']['highest1v1Rank']) ? $apiData['career']['highest1v1Rank'] : null)
            ->setHighestTeamRank(isset($apiData['career']['highestTeamRank']) ? $apiData['career']['highestTeamRank'] : null)
            ->setSeasonTotalGames(isset($apiData['career']['seasonTotalGames']) ? $apiData['career']['seasonTotalGames'] : null)
            ->setCareerTotalGames(isset($apiData['career']['careerTotalGames']) ? $apiData['career']['careerTotalGames'] : null);
        return $career;
    }

    /**
     * @param $apiData
     * @return PlayerSwarmLevels
     */
    protected function extractPlayerSwarmLevelsFromProfileData($apiData)
    {
        $terranSwarmLevel = new SwarmLevel();
        $terranSwarmLevel->setLevel($apiData['swarmLevels']['terran']['level'])
            ->setTotalLevelXp($apiData['swarmLevels']['terran']['totalLevelXP'])
            ->setCurrentLevelXp($apiData['swarmLevels']['terran']['currentLevelXP']);

        $protossSwarmLevel = new SwarmLevel();
        $protossSwarmLevel->setLevel($apiData['swarmLevels']['protoss']['level'])
            ->setTotalLevelXp($apiData['swarmLevels']['protoss']['totalLevelXP'])
            ->setCurrentLevelXp($apiData['swarmLevels']['protoss']['currentLevelXP']);

        $zergSwarmLevel = new SwarmLevel();
        $zergSwarmLevel->setLevel($apiData['swarmLevels']['zerg']['level'])
            ->setTotalLevelXp($apiData['swarmLevels']['zerg']['totalLevelXP'])
            ->setCurrentLevelXp($apiData['swarmLevels']['zerg']['currentLevelXP']);

        $playerSwarmLevels = new PlayerSwarmLevels();
        $playerSwarmLevels->setPlayerLevel($apiData['swarmLevels']['level'])
            ->setTerranLevel($terranSwarmLevel)
            ->setProtossLevel($protossSwarmLevel)
            ->setZergLevel($zergSwarmLevel);
        return $playerSwarmLevels;
    }
}