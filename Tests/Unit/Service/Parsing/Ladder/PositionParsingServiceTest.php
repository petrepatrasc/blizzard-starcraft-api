<?php

namespace petrepatrasc\BlizzardApiBundle\Tests\Unit\Service\Parsing\Ladder;


use petrepatrasc\BlizzardApiBundle\Service\Parsing\Ladder\PositionParsingService;

class PositionParsingServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $mockData
     * @dataProvider extractDataProvider
     */
    public function testExtract($mockData)
    {
        $result = PositionParsingService::extract($mockData);

        $joinDate = new \DateTime();
        $joinDate->setTimestamp($mockData['joinTimestamp']);

        $this->assertEquals($joinDate, $result->getJoinDate());
        $this->assertEquals($mockData['points'], $result->getPoints());
        $this->assertEquals($mockData['wins'], $result->getWins());
        $this->assertEquals($mockData['losses'], $result->getLosses());
        $this->assertEquals($mockData['highestRank'], $result->getHighestRank());
        $this->assertEquals($mockData['previousRank'], $result->getPreviousRank());

        if (isset($mockData['favoriteRaceP1'])) {
            $this->assertEquals($mockData['favoriteRaceP1'], $result->getFavoriteRaceP1());
        } else {
            $this->assertNull($result->getFavoriteRaceP1());
        }

        $this->assertEquals($mockData['character']['id'], $result->getCharacter()->getId());
        $this->assertEquals($mockData['character']['realm'], $result->getCharacter()->getRealm());
        $this->assertEquals($mockData['character']['displayName'], $result->getCharacter()->getDisplayName());
        $this->assertEquals($mockData['character']['clanName'], $result->getCharacter()->getClanName());
        $this->assertEquals($mockData['character']['clanTag'], $result->getCharacter()->getClanTag());
        $this->assertEquals($mockData['character']['profilePath'], $result->getCharacter()->getProfilePath());
    }

    public function extractDataProvider() {
        $mockDataWithoutFavouriteRace = array(
            'character' => array(
                'id' => 1809545,
                'realm' => 1,
                'displayName' => 'Lucifer',
                'clanName' => 'Team Inevitable',
                'clanTag' => 'Inev',
                'profilePath' => '/profile/1809545/1/Lucifer/'
            ),
            'joinTimestamp' => 1389363377,
            'points' => 984.3,
            'wins' => 53,
            'losses' => 39,
            'highestRank' => 3,
            'previousRank' => 25,
        );

        $completeMockData = array_merge($mockDataWithoutFavouriteRace, array('favoriteRaceP1' => 'TERRAN'));

        return array(
            array($mockDataWithoutFavouriteRace),
            array($completeMockData)
        );
    }
}