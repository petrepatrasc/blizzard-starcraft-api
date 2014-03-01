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

        $portrait = $this->extractPlayerPortraitFromProfileData($apiData);
        $career = $this->extractPlayerCareerFromProfileData($apiData);
        $playerSwarmLevels = $this->extractPlayerSwarmLevelsFromProfileData($apiData);
        $campaign = $this->extractCampaignDataFromProfile($apiData);
        $season = $this->extractSeasonDataFromProfile($apiData);
        $rewards = $this->extractRewardsDataFromProfile($apiData);
        $achievements = $this->extractAchievementDataFromProfile($apiData);


        $player = new Player();
        $player->setId(isset($apiData['id']) ? $apiData['id'] : null)
            ->setRealm(isset($apiData['realm']) ? $apiData['realm'] : null)
            ->setDisplayName(isset($apiData['displayName']) ? $apiData['displayName'] : null)
            ->setClanName(isset($apiData['clanName']) ? $apiData['clanName'] : null)
            ->setClanTag(isset($apiData['clanTag']) ? $apiData['clanTag'] : null)
            ->setProfilePath(isset($apiData['profilePath']) ? $apiData['profilePath'] : null)
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
     * Return a normalised player profile array, so that we have defaults set for everything in the event that certain
     * values aren't set in the array returned by the API.
     * @return array
     */
    protected function getNormalisedPlayerProfileArray()
    {
        return array(
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

        $portrait->setXCoordinate($this->getPortraitData($apiData, 'x'))
            ->setYCoordinate($this->getPortraitData($apiData, 'y'))
            ->setWidth($this->getPortraitData($apiData, 'w'))
            ->setHeight($this->getPortraitData($apiData, 'h'))
            ->setOffset($this->getPortraitData($apiData, 'offset'))
            ->setUrl($this->getPortraitData($apiData, 'url'));
        return $portrait;
    }

    /**
     * Get the portrait data if it is set.
     *
     * @param array $apiData
     * @param string $key
     * @return null
     */
    protected function getPortraitData($apiData, $key)
    {
        $portrait = $apiData['portrait'];

        if (isset($portrait[$key])) {
            return $portrait[$key];
        }

        return null;
    }

    /**
     * @param $apiData
     * @return Player\Career
     */
    protected function extractPlayerCareerFromProfileData($apiData)
    {
        $career = new Player\Career();
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
     * @return Player\SwarmLevels
     */
    protected function extractPlayerSwarmLevelsFromProfileData($apiData)
    {
        $terranSwarmLevel = new SwarmLevel();
        $terranSwarmLevel->setLevel(isset($apiData['swarmLevels']['terran']['level']) ? $apiData['swarmLevels']['terran']['level'] : null)
            ->setTotalLevelXp(isset($apiData['swarmLevels']['terran']['totalLevelXP']) ? $apiData['swarmLevels']['terran']['totalLevelXP'] : null)
            ->setCurrentLevelXp(isset($apiData['swarmLevels']['terran']['currentLevelXP']) ? $apiData['swarmLevels']['terran']['currentLevelXP'] : null);

        $protossSwarmLevel = new SwarmLevel();
        $protossSwarmLevel->setLevel(isset($apiData['swarmLevels']['protoss']['level']) ? $apiData['swarmLevels']['protoss']['level'] : null)
            ->setTotalLevelXp(isset($apiData['swarmLevels']['protoss']['totalLevelXP']) ? $apiData['swarmLevels']['protoss']['totalLevelXP'] : null)
            ->setCurrentLevelXp(isset($apiData['swarmLevels']['protoss']['currentLevelXP']) ? $apiData['swarmLevels']['protoss']['currentLevelXP'] : null);

        $zergSwarmLevel = new SwarmLevel();
        $zergSwarmLevel->setLevel(isset($apiData['swarmLevels']['zerg']['level']) ? $apiData['swarmLevels']['zerg']['level'] : null)
            ->setTotalLevelXp(isset($apiData['swarmLevels']['zerg']['totalLevelXP']) ? $apiData['swarmLevels']['zerg']['totalLevelXP'] : null)
            ->setCurrentLevelXp(isset($apiData['swarmLevels']['zerg']['currentLevelXP']) ? $apiData['swarmLevels']['zerg']['currentLevelXP'] : null);

        $playerSwarmLevels = new Player\SwarmLevels();
        $playerSwarmLevels->setPlayerLevel(isset($apiData['swarmLevels']['level']) ? $apiData['swarmLevels']['level'] : null)
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
        $campaign->setWingsOfLibertyStatus(isset($apiData['campaign']['wol']) ? $apiData['campaign']['wol'] : null)
            ->setHeartOfTheSwarmStatus(isset($apiData['campaign']['hots']) ? $apiData['campaign']['hots'] : null);
        return $campaign;
    }

    /**
     * @param $apiData
     * @return \petrepatrasc\BlizzardApiBundle\Entity\Player\Season
     */
    protected function extractSeasonDataFromProfile($apiData)
    {
        $season = new Player\Season();
        $season->setSeasonId(isset($apiData['season']['seasonId']) ? $apiData['season']['seasonId'] : null)
            ->setTotalGamesThisSeason(isset($apiData['season']['totalGamesThisSeason']) ? $apiData['season']['totalGamesThisSeason'] : null)
            ->setSeasonNumber(isset($apiData['season']['seasonNumber']) ? $apiData['season']['seasonNumber'] : null)
            ->setSeasonYear(isset($apiData['season']['seasonYear']) ? $apiData['season']['seasonYear'] : null);

        if (!isset($apiData['season']['stats'])) {
            return $season;
        }

        foreach ($apiData['season']['stats'] as $stats) {
            $seasonStats = new SeasonStats();
            $seasonStats->setType(isset($stats['type']) ? $stats['type'] : null)
                ->setWins(isset($stats['wins']) ? $stats['wins'] : null)
                ->setGames(isset($stats['games']) ? $stats['games'] : null);
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
        $rewards->setSelected(isset($apiData['rewards']['selected']) ? $apiData['rewards']['selected'] : null)
            ->setEarned(isset($apiData['rewards']['earned']) ? $apiData['rewards']['earned'] : null);
        return $rewards;
    }

    /**
     * @param $apiData
     * @return Player\Achievements
     */
    protected function extractAchievementDataFromProfile($apiData)
    {
        $points = new Points();
        $points->setTotalPoints(isset($apiData['achievements']['points']['totalPoints']) ? $apiData['achievements']['points']['totalPoints'] : null)
            ->setCategoryPoints(isset($apiData['achievements']['points']['categoryPoints']) ? $apiData['achievements']['points']['categoryPoints'] : null);

        $achievements = new Player\Achievements();
        $achievements->setPoints($points);

        foreach ($apiData['achievements']['achievements'] as $achievementEntry) {
            $completionDate = new \DateTime();
            $completionDate->setTimestamp(isset($achievementEntry['completionDate']) ? $achievementEntry['completionDate'] : null);

            $achievementEntity = new Achievement();
            $achievementEntity->setAchievementId(isset($achievementEntry['achievementId']) ? $achievementEntry['achievementId'] : null)
                ->setCompletionDate($completionDate);

            $achievements->addAchievements($achievementEntity);
        }
        return $achievements;
    }
}