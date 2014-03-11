<?php

namespace petrepatrasc\BlizzardApiBundle\Service\Parsing\Reward;

use petrepatrasc\BlizzardApiBundle\Entity\Reward\Information;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\ParsingInterfaceStandalone;

class InformationParsingService implements ParsingInterfaceStandalone{

    /**
     * Extract campaign information from an array.
     *
     * @param array $params
     * @return Information
     */
    public static function extract($params)
    {
        $information = new Information();

        $portraits = self::extractPortraits($params);
        $information->setPortraits($portraits);
        unset($portraits);

        $terranDecals = self::extractDecals($params, 'terranDecals');
        $information->setTerranDecals($terranDecals);
        unset($terranDecals);

        $protossDecals = self::extractDecals($params, 'protossDecals');
        $information->setProtossDecals($protossDecals);
        unset($protossDecals);

        $zergDecals = self::extractDecals($params, 'zergDecals');
        $information->setZergDecals($zergDecals);
        unset($zergDecals);

        $skins = self::extractSkins($params);
        $information->setSkins($skins);
        unset($skins);

        $animations = self::extractAnimations($params);
        $information->setAnimations($animations);
        unset($animations);

        return $information;
    }

    /**
     * @param $params
     * @return array
     */
    protected static function extractPortraits($params)
    {
        $portraits = array();
        foreach ($params['portraits'] as $portrait) {
            $portraits[] = PortraitParsingService::extract($portrait);
        }
        return $portraits;
    }

    /**
     * @param array $params
     * @param string $key The key which should be used for parsing the decals.
     * @return array
     */
    protected static function extractDecals($params, $key)
    {
        $terranDecals = array();
        foreach ($params[$key] as $terranDecal) {
            $terranDecals[] = DecalParsingService::extract($terranDecal);
        }
        return $terranDecals;
    }

    /**
     * @param $params
     * @return array
     */
    protected static function extractSkins($params)
    {
        $skins = array();
        foreach ($params['skins'] as $skin) {
            $skins[] = SkinParsingService::extract($skin);
        }
        return $skins;
    }

    /**
     * @param $params
     * @return array
     */
    protected static function extractAnimations($params)
    {
        $animations = array();
        foreach ($params['animations'] as $animation) {
            $animations[] = AnimationParsingService::extract($animation);
        }
        return $animations;
    }
}