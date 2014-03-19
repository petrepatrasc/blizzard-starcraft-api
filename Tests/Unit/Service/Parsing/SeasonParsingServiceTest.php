<?php

namespace petrepatrasc\BlizzardApiBundle\Tests\Unit\Service\Parsing;


use petrepatrasc\BlizzardApiBundle\Entity\SeasonStats;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\SeasonParsingService;

class SeasonParsingServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testExtract()
    {
        $mockData = array(
            'seasonId' => 17,
            'totalGamesThisSeason' => 160,
            'stats' => array(
                array(
                    'type' => '1v1',
                    'wins' => 52,
                    'games' => 73
                )
            ),
            'seasonNumber' => 1,
            'seasonYear' => 2014
        );

        $result = SeasonParsingService::extract($mockData);

        $this->assertEquals($mockData['seasonId'], $result->getSeasonId());
        $this->assertEquals($mockData['totalGamesThisSeason'], $result->getTotalGamesThisSeason());
        $this->assertEquals($mockData['seasonNumber'], $result->getSeasonNumber());
        $this->assertEquals($mockData['seasonYear'], $result->getSeasonYear());

        /**
         * @var $statsEntry SeasonStats
         */
        $statsArray = $result->getStats();
        $statsEntry = $statsArray[0];

        $this->assertEquals($mockData['stats'][0]['type'], $statsEntry->getType());
        $this->assertEquals($mockData['stats'][0]['wins'], $statsEntry->getWins());
        $this->assertEquals($mockData['stats'][0]['games'], $statsEntry->getGames());
    }

    public function testExtractSeasonStatsData()
    {
        $mockData = array(
            'stats' => array(
                array(
                    'type' => '1v1',
                    'wins' => 52,
                    'games' => 73
                )
            )
        );

        $result = SeasonParsingService::extractSeasonStatsData($mockData);

        /**
         * @var $statsEntry SeasonStats
         */
        $statsEntry = $result[0];

        $this->assertEquals($mockData['stats'][0]['type'], $statsEntry->getType());
        $this->assertEquals($mockData['stats'][0]['wins'], $statsEntry->getWins());
        $this->assertEquals($mockData['stats'][0]['games'], $statsEntry->getGames());
    }
}