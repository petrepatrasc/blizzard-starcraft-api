<?php

namespace petrepatrasc\BlizzardApiBundle\Service;

use petrepatrasc\BlizzardApiBundle\Entity;
use petrepatrasc\BlizzardApiBundle\Service\Parsing;

class ApiService
{
    const API_PROFILE_METHOD = '/api/sc2/profile/';
    const API_LADDER_METHOD = '/api/sc2/ladder/';
    const API_REWARDS_METHOD = '/api/sc2/data/rewards';
    const API_ACHIEVEMENTS_METHOD = '/api/sc2/data/achievements';

    /**
     * @var CallService
     */
    protected $callService = null;

    /**
     * @param CallService $callService
     */
    public function __construct($callService = null)
    {
        if (is_null($callService)) {
            $callService = new CallService();
        }

        $this->callService = $callService;
    }

    /**
     * Get a player's profile via the Battle.NET API.
     *
     * @param string $region
     * @param int $battleNetId
     * @param int $realm
     * @param string $playerName
     * @return Entity\Player
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
     * @return Entity\Player\Ladder
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

    /**
     * Get information on the rewards that are available.
     *
     * @param string $region The region from which the data should be retrieved.
     * @return Entity\Reward\Information
     */
    public function getRewardsInformationData($region)
    {
        $apiData = $this->makeCall($region, self::API_REWARDS_METHOD, array(), false);

        $information = Parsing\Reward\InformationParsingService::extract($apiData);
        return $information;
    }

    /**
     * Get information on the achievements that are available.
     *
     * @param string $region The region from which the data should be retrieved.
     * @return Entity\Achievement\Information
     */
    public function getAchievementsInformationData($region)
    {
        $apiData = $this->makeCall($region, self::API_ACHIEVEMENTS_METHOD, array(), false);

        $information = Parsing\Achievement\InformationParsingService::extract($apiData);
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
     * Make a call to the public API.
     *
     * @param string $region The region that should be used.
     * @param string $apiMethod The API method that should be called.
     * @param array $params The parameters that should be attached to the method call.
     * @param bool $trailingSlash Whether or not to include a trailing slash in the request (makes a large difference)
     * @throws Entity\Exception\BlizzardApiException
     * @return array JSON decoded array of the response.
     */
    public function makeCall($region, $apiMethod, $params = array(), $trailingSlash = true)
    {
        try {
            $apiResponse = $this->callService->makeCallToApiService($region, $apiMethod, $params, $trailingSlash);
        } catch (\Exception $exception) {
            throw new Entity\Exception\BlizzardApiException($exception->getMessage(), $exception->getCode());
        }

        if (isset($apiResponse['status']) && $apiResponse['status'] = 'nok') {
            $exception = new Entity\Exception\BlizzardApiException($apiResponse['message'], $apiResponse['code']);
            throw $exception;
        }

        return json_decode($apiResponse, true);
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