<?php

namespace petrepatrasc\BlizzardApiBundle\Service;

use petrepatrasc\BlizzardApiBundle\Entity\Achievement\Points;
use petrepatrasc\BlizzardApiBundle\Entity\Achievement;
use petrepatrasc\BlizzardApiBundle\Entity\Player;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Campaign;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Career;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Portrait;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Rewards;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Season;
use petrepatrasc\BlizzardApiBundle\Entity\Player\SwarmLevels;
use petrepatrasc\BlizzardApiBundle\Entity\SeasonStats;
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

        $portrait = $this->extractPlayerPortraitFromProfileData($apiData);
        $career = $this->extractPlayerCareerFromProfileData($apiData);
        $playerSwarmLevels = $this->extractPlayerSwarmLevelsFromProfileData($apiData);
        $campaign = $this->extractCampaignDataFromProfile($apiData);
        $season = $this->extractSeasonDataFromProfile($apiData);
        $rewards = $this->extractRewardsDataFromProfile($apiData);
        $achievements = $this->extractAchievementDataFromProfile($apiData);


        $player = new Player();
        $player->setId($apiData['id'])
            ->setRealm($apiData['realm'])
            ->setDisplayName($apiData['displayName'])
            ->setClanName($apiData['clanName'])
            ->setClanTag($apiData['clanTag'])
            ->setProfilePath($apiData['profilePath'])
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
     * @param string $region
     * @param string $apiMethod
     * @param array $params
     * @return mixed
     */
    public function makeCall($region, $apiMethod, $params = array())
    {
        return json_decode($this->callService->makeCallToApiService($region, $apiMethod, $params), true);
    }

    /**
     * @param $apiData
     * @return Portrait
     */
    protected function extractPlayerPortraitFromProfileData($apiData)
    {
        $portrait = new Portrait();

        if (!isset($apiData['portrait'])) {
            return $portrait;
        }

        $portrait->setXCoordinate($apiData['portrait']['x'])
            ->setYCoordinate($apiData['portrait']['y'])
            ->setWidth($apiData['portrait']['w'])
            ->setHeight($apiData['portrait']['h'])
            ->setOffset($apiData['portrait']['offset'])
            ->setUrl($apiData['portrait']['url']);
        return $portrait;
    }

    /**
     * @param $apiData
     * @return Player\Career
     */
    protected function extractPlayerCareerFromProfileData($apiData)
    {
        $career = new Player\Career();
        $career->setPrimaryRace($apiData['career']['primaryRace'])
            ->setLeague($apiData['career']['league'])
            ->setTerranWins($apiData['career']['terranWins'])
            ->setProtossWins($apiData['career']['protossWins'])
            ->setZergWins($apiData['career']['zergWins'])
            ->setHighest1v1Rank($apiData['career']['highest1v1Rank'])
            ->setHighestTeamRank($apiData['career']['highestTeamRank'])
            ->setSeasonTotalGames($apiData['career']['seasonTotalGames'])
            ->setCareerTotalGames($apiData['career']['careerTotalGames']);
        return $career;
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
     * values aren't set in the array returned by the API.
     * @param array $apiData
     * @return array
     */
    protected function getNormalisedPlayerProfileArray($apiData = array())
    {
        $normalisedArray = array(
            'id' => null,
            'realm' => null,
            'displayName' => null,
            'clanName' => null,
            'clanTag' => null,
            'profilePath' => null,
            'portrait' => array(
                'x' => null,
                'y' => null,
                'w' => null,
                'h' => null,
                'offset' => null,
                'url' => null
            ),
            'career' => array(
                'primaryRace' => null,
                'league' => null,
                'terranWins' => null,
                'protossWins' => null,
                'zergWins' => null,
                'highest1v1Rank' => null,
                'highestTeamRank' => null,
                'seasonTotalGames' => null,
                'careerTotalGames' => null
            ),
            'swarmLevels' => array(
                'level' => null,
                'terran' => array(
                    'level' => null,
                    'totalLevelXP' => null,
                    'currentLevelXP' => null
                ),
                'zerg' => array(
                    'level' => null,
                    'totalLevelXP' => null,
                    'currentLevelXP' => null
                ),
                'protoss' => array(
                    'level' => null,
                    'totalLevelXP' => null,
                    'currentLevelXP' => null
                )
            ),
            'campaign' => array(
                'wol' => null,
                'hots' => null
            ),
            'season' => array(
                'seasonId' => null,
                'totalGamesThisSeason' => null,
                'stats' => array(),
                'seasonNumber' => null,
                'seasonYear' => null
            ),
            'rewards' => array(
                'selected' => array(),
                'earned' => array()
            ),
            'achievements' => array(
                'points' => array(
                    'totalPoints' => null,
                    'categoryPoints' => array(
                        '4325382' => null,
                        '4325380' => null,
                        '4325408' => null,
                        '4325379' => null,
                        '4325410' => null,
                        '4325377' => null
                    )
                ),
                'achievements' => array()
            )
        );

        $apiData['campaign'] = array_merge($normalisedArray['campaign'], $apiData['campaign']);
        $apiData['career'] = array_merge($normalisedArray['career'], $apiData['career']);
        return $apiData;
    }
}