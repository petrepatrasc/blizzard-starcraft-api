<?php

namespace petrepatrasc\BlizzardApiBundle\Service;

/**
 * Handles calling the Battle.NET service. Added for extensibility at the moment.
 * @package petrepatrasc\BlizzardApiBundle\Service
 */
class CallService
{

    /**
     * Make a call to the Battle.NET Api Service.
     *
     * @param string $region
     * @param string $apiMethod
     * @param array $params
     * @return string
     */
    public function makeCallToApiService($region, $apiMethod, $params = array())
    {
        $urlParameters = implode('/', $params);
        $battleNetUrl = $region . $apiMethod . $urlParameters . '/';

        $result = file_get_contents($battleNetUrl);
        return $result;
    }
}