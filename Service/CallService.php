<?php

namespace petrepatrasc\BlizzardApiBundle\Service;
use petrepatrasc\BlizzardApiBundle\Entity\Exception\BlizzardApiException;
use petrepatrasc\StarcraftConnectionLayerBundle\Service\ConnectionService;

/**
 * Handles calling the Battle.NET service. Added for extensibility at the moment.
 * @package petrepatrasc\BlizzardApiBundle\Service
 */
class CallService
{
    /**
     * @var ConnectionService
     */
    protected $connectivityLayer;

    /**
     * Class constructor.
     */
    public function __construct() {
        $this->connectivityLayer = new ConnectionService();
    }

    /**
     * Make a call to the Battle.NET Api Service.
     *
     * @param string $region
     * @param string $apiMethod
     * @param array $params
     * @param bool $trailingSlash
     * @throws \petrepatrasc\BlizzardApiBundle\Entity\Exception\BlizzardApiException
     * @return string
     */
    public function makeCallToApiService($region, $apiMethod, $params = array(), $trailingSlash = true)
    {
        $urlParameters = implode('/', $params);
        $battleNetUrl = $region . $apiMethod . $urlParameters;

        if ($trailingSlash) {
            $battleNetUrl .= '/';
        }

        $result = $this->getConnectivityLayer()->getBlizzardApi()->retrieveData($battleNetUrl);

        if ($result === null) {
            throw new BlizzardApiException("No data was returned from the server", 500);
        } else {
            return $result;
        }
    }

    /**
     * @param \petrepatrasc\StarcraftConnectionLayerBundle\Service\ConnectionService $connectivityLayer
     * @return $this
     */
    public function setConnectivityLayer($connectivityLayer)
    {
        $this->connectivityLayer = $connectivityLayer;
        return $this;
    }

    /**
     * @return \petrepatrasc\StarcraftConnectionLayerBundle\Service\ConnectionService
     */
    public function getConnectivityLayer()
    {
        return $this->connectivityLayer;
    }
}