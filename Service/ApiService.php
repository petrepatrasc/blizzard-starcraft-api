<?php

namespace petrepatrasc\BlizzardApiBundle\Service;

use petrepatrasc\BlizzardApiBundle\Entity\Achievement;
use petrepatrasc\BlizzardApiBundle\Entity\Player;
use petrepatrasc\BlizzardApiBundle\Service\Parsing;

class ApiService
{
    const API_PROFILE_METHOD = '/api/sc2/profile/';
    const API_LADDER_METHOD = '/api/sc2/ladder/';
    const API_REWARDS_METHOD = '/api/sc2/data/rewards';

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

        return Parsing\PlayerProfileParsingService::extract($apiData);
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
    public function getPlayerLatestMatches($region, $battleNetId, $playerName, $realm = 1)
    {
        $apiParameters = array($battleNetId, $realm, $playerName, 'matches');
        $apiData = $this->makeCall($region, self::API_PROFILE_METHOD, $apiParameters, false);

        $matches = array();
        foreach ($apiData['matches'] as $match) {
            $matches[] = Parsing\MatchParsingService::extract($match);
        }

        return $matches;
    }

    /**
     * Get information regarding a player's ladders.
     *
     * @param string $region
     * @param int $battleNetId
     * @param string $playerName
     * @param int $realm
     * @return Player\Ladder
     */
    public function getPlayerLaddersInformation($region, $battleNetId, $playerName, $realm = 1)
    {
        $apiParameters = array($battleNetId, $realm, $playerName, 'ladders');
        $apiData = $this->makeCall($region, self::API_PROFILE_METHOD, $apiParameters, false);

        $playerLadder = Parsing\Player\LadderParsingService::extract($apiData);

        return $playerLadder;
    }

    /**
     * Get information on the grandmaster league from a region.
     *
     * @param string $region The region for the API, use the Region class in order to maintain consistency.
     * @param bool $previousSeason Whether the information should be for the previous season or not.
     * @return array Array containing all of the ladder members as LadderPosition instances.
     */
    public function getGrandmasterLeagueInformation($region, $previousSeason = false)
    {
        $parameters = array('grandmaster');

        if ($previousSeason) {
            $parameters[] = 'last';
        }

        return $this->getLeagueInformationWrapper($region, $parameters);
    }

    /**
     * Get information on a particular league from a region.
     *
     * @param string $region The region for the API, use the Region class in order to maintain consistency.
     * @param int $id The ID of the league.
     * @return array
     */
    public function getLeagueInformation($region, $id)
    {
        $parameters = array($id);
        return $this->getLeagueInformationWrapper($region, $parameters);
    }

    public function getRewardsInformationData($region) {
        $apiData = $this->makeCall($region, self::API_REWARDS_METHOD, array(), false);

        $information = Parsing\Reward\InformationParsingService::extract($apiData);
        return $information;
    }

    /**
     * Customisable league method, try using the wrapper methods first.
     *
     * @param string $region The region, use the Region class in order to maintain consistency.
     * @param array $parameters The parameters that should be passed to the league API method.
     * @return array Array containing all of the ladder members as LadderPosition instances.
     */
    protected function getLeagueInformationWrapper($region, $parameters)
    {
        $apiData = $this->makeCall($region, self::API_LADDER_METHOD, $parameters, false);

        $ladderMembers = array();
        foreach ($apiData['ladderMembers'] as $member) {
            $ladderMembers[] = Parsing\Ladder\PositionParsingService::extract($member);
        }

        return $ladderMembers;
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