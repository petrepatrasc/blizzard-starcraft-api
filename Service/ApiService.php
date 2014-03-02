<?php

namespace petrepatrasc\BlizzardApiBundle\Service;

use petrepatrasc\BlizzardApiBundle\Entity\Achievement\Points;
use petrepatrasc\BlizzardApiBundle\Entity\Achievement;
use petrepatrasc\BlizzardApiBundle\Entity\Match;
use petrepatrasc\BlizzardApiBundle\Entity\Player;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Campaign;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Career;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Portrait;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Rewards;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Season;
use petrepatrasc\BlizzardApiBundle\Entity\Player\SwarmLevels;
use petrepatrasc\BlizzardApiBundle\Entity\SeasonStats;
use petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\BasicProfileService;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\CareerService;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\PortraitService;

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
     * @param string $region
     * @param int $battleNetId
     * @param int $realm
     * @param string $playerName
     * @return Player
     */
    public function getPlayerProfile($region, $battleNetId, $playerName, $realm = 1)
    {
        $apiParameters = array($battleNetId, $realm, $playerName);
        $apiData = $this->makeCall($region, self::API_PROFILE_METHOD, $apiParameters);
        $apiData = $this->getNormalisedPlayerProfileArray($apiData);

        $portrait = PortraitService::extract($apiData['portrait']);
        $career = CareerService::extract($apiData['career']);
        $playerSwarmLevels = $this->extractPlayerSwarmLevelsFromProfileData($apiData);
        $campaign = $this->extractCampaignDataFromProfile($apiData);
        $season = $this->extractSeasonDataFromProfile($apiData);
        $rewards = $this->extractRewardsDataFromProfile($apiData);
        $achievements = $this->extractAchievementDataFromProfile($apiData);
        $profileBasicInformation = BasicProfileService::extract($apiData);

        $player = new Player();
        $player->setBasicInformation($profileBasicInformation)
            ->setPortrait($portrait)
            ->setCareer($career)
            ->setSwarmLevels($playerSwarmLevels)
            ->setCampaign($campaign)
            ->setSeason($season)
            ->setRewards($rewards)
            ->setAchievements($achievements);

        return $player;
    }

    /**
     * Get the last ten matches that a player has played.
     *
     * @param string $region
     * @param int $battleNetId
     * @param string $playerName
     * @param int $realm
     * @return array
     */
    public function getLatestMatchesPlayedByPlayer($region, $battleNetId, $playerName, $realm = 1)
    {
        $apiParameters = array($battleNetId, $realm, $playerName, 'matches');
        $apiData = $this->makeCall($region, self::API_PROFILE_METHOD, $apiParameters, false);

        $matches = array();
        foreach ($apiData['matches'] as $apiMatch) {
            $matchDate = new \DateTime();
            $matchDate->setTimestamp($apiMatch['date']);

            $match = new Match();
            $match->setMap($apiMatch['map'])
                ->setType($apiMatch['type'])
                ->setDecision($apiMatch['decision'])
                ->setSpeed($apiMatch['speed'])
                ->setDate($matchDate);

            $matches[] = $match;
        }

        return $matches;
    }

    /**
     * @param string $region
     * @param string $apiMethod
     * @param array $params
     * @param bool $trailingSlash
     * @return array
     */
    public function makeCall($region, $apiMethod, $params = array(), $trailingSlash = true)
    {
        return json_decode($this->callService->makeCallToApiService($region, $apiMethod, $params, $trailingSlash), true);
    }

    /**
     * @param $apiData
     * @return Player\SwarmLevels
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

        $playerSwarmLevels = new Player\SwarmLevels();
        $playerSwarmLevels->setPlayerLevel($apiData['swarmLevels']['level'])
            ->setTerranLevel($terranSwarmLevel)
            ->setProtossLevel($protossSwarmLevel)
            ->setZergLevel($zergSwarmLevel);
        return $playerSwarmLevels;
    }

    /**
     * @param $apiData
     * @return Player\Campaign
     */
    protected function extractCampaignDataFromProfile($apiData)
    {
        $campaign = new Player\Campaign();
        $campaign->setWingsOfLibertyStatus($apiData['campaign']['wol'])
            ->setHeartOfTheSwarmStatus($apiData['campaign']['hots']);
        return $campaign;
    }

    /**
     * @param $apiData
     * @return \petrepatrasc\BlizzardApiBundle\Entity\Player\Season
     */
    protected function extractSeasonDataFromProfile($apiData)
    {
        $season = new Player\Season();
        $season->setSeasonId($apiData['season']['seasonId'])
            ->setTotalGamesThisSeason($apiData['season']['totalGamesThisSeason'])
            ->setSeasonNumber($apiData['season']['seasonNumber'])
            ->setSeasonYear($apiData['season']['seasonYear']);

        if (!isset($apiData['season']['stats'])) {
            return $season;
        }

        foreach ($apiData['season']['stats'] as $stats) {
            $seasonStats = new SeasonStats();
            $seasonStats->setType($stats['type'])
                ->setWins($stats['wins'])
                ->setGames($stats['games']);
            $season->addSeasonStats($seasonStats);
        }

        return $season;
    }

    /**
     * @param $apiData
     * @return Player\Rewards
     */
    protected function extractRewardsDataFromProfile($apiData)
    {
        $rewards = new Player\Rewards();
        $rewards->setSelected($apiData['rewards']['selected'])
            ->setEarned($apiData['rewards']['earned']);
        return $rewards;
    }

    /**
     * @param $apiData
     * @return Player\Achievements
     */
    protected function extractAchievementDataFromProfile($apiData)
    {
        $points = new Points();
        $points->setTotalPoints($apiData['achievements']['points']['totalPoints'])
            ->setCategoryPoints($apiData['achievements']['points']['categoryPoints']);

        $achievements = new Player\Achievements();
        $achievements->setPoints($points);

        foreach ($apiData['achievements']['achievements'] as $achievementEntry) {
            $completionDate = new \DateTime();
            $completionDate->setTimestamp($achievementEntry['completionDate']);

            $achievementEntity = new Achievement();
            $achievementEntity->setAchievementId($achievementEntry['achievementId'])
                ->setCompletionDate($completionDate);

            $achievements->addAchievements($achievementEntity);
        }
        return $achievements;
    }

    /**
     * Return a normalised player profile array, so that we have defaults set for everything in the event that certain
     * values are not set in the array returned by the API.
     * @param array $apiData
     * @return array
     */
    protected function getNormalisedPlayerProfileArray($apiData = array())
    {
        $normalisedArray = NormalisationService::getNormalisedPlayerProfile();

        $apiData['campaign'] = array_merge($normalisedArray['campaign'], $apiData['campaign']);
        $apiData['career'] = array_merge($normalisedArray['career'], $apiData['career']);
        return $apiData;
    }
}