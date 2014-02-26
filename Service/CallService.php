<?php

namespace petrepatrasc\BlizzardApiBundle\Service;

/**
 * Handles calling the Battle.NET service. Added for extensibility at the moment.
 * @package petrepatrasc\BlizzardApiBundle\Service
 */
class CallService {

    /**
     * Make a call to the Battle.NET Api Service.
     *
     * @param string $locale
     * @param string $apiMethod
     * @param array $params
     * @return string
     */
    public function makeCallToApiService($locale, $apiMethod, $params = array()) {
        $urlParameters = implode('/', $params);
        $battleNetUrl = 'http://' . $locale . '.battle.net' . $apiMethod . $urlParameters . '/';

        $result = file_get_contents($battleNetUrl);
    }
}