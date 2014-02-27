<?php

namespace petrepatrasc\BlizzardApiBundle\Service;

use petrepatrasc\BlizzardApiBundle\Entity\Achievement\Points;
use petrepatrasc\BlizzardApiBundle\Entity\Achievement;
use petrepatrasc\BlizzardApiBundle\Entity\Player;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Campaign;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Career;
use petrepatrasc\BlizzardApiBundle\Entity\PlayerPortrait;
use petrepatrasc\BlizzardApiBundle\Entity\PlayerRewards;
use petrepatrasc\BlizzardApiBundle\Entity\PlayerSeason;
use petrepatrasc\BlizzardApiBundle\Entity\PlayerSwarmLevels;
use petrepatrasc\BlizzardApiBundle\Entity\SeasonStats;
use petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel;
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @return \petrepatrasc\BlizzardApiBundle\Entity\PlayerSeason
     */
    protected function extractSeasonDataFromProfile($apiData)
    {
        $season = new PlayerSeason();
        $season->setSeasonId($apiData['season']['seasonId'])
            ->setTotalGamesThisSeason($apiData['season']['totalGamesThisSeason'])
            ->setSeasonNumber($apiData['season']['seasonNumber'])
            ->setSeasonYear($apiData['season']['seasonYear']);

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
     * @return PlayerRewards
     */
    protected function extractRewardsDataFromProfile($apiData)
    {
        $rewards = new PlayerRewards();
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
}