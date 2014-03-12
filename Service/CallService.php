<?php

namespace petrepatrasc\BlizzardApiBundle\Service;
use petrepatrasc\BlizzardApiBundle\Entity\Exception\BlizzardApiException;

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

        $result = @file_get_contents($battleNetUrl);

        if ($result === FALSE) {
            throw new BlizzardApiException("Failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found", 404);
        } else {
            return $result;
        }
    }
}