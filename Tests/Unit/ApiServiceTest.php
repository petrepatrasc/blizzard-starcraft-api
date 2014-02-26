<?php

class ApiServiceTest extends PHPUnit_Framework_TestCase
{
    const PROFILE_MOCK_PATH = './Resources/mocks/profile-retrieval.json';

    /**
     * @var \petrepatrasc\BlizzardApiBundle\Service\ApiService
     */
    protected $apiService = null;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $callServiceMock = null;

    public function setUp()
    {
        parent::setUp();

        $this->callServiceMock = $this->getMock('CallService', array('makeCallToApiService'));

        $this->apiService = new \petrepatrasc\BlizzardApiBundle\Service\ApiService($this->callServiceMock);
    }

    public function testGetPlayerProfile()
    {
        $this->callServiceMock->expects($this->atLeastOnce())->method('makeCallToApiService')->withAnyParameters()->will($this->returnValue(file_get_contents(self::PROFILE_MOCK_PATH)));
        $profile = $this->apiService->getPlayerProfile('eu', 2048419, 'LionHeart');

        // Player general verification
        $this->assertEquals(2048419, $profile->getId());
        $this->assertEquals(1, $profile->getRealm());
        $this->assertEquals("LionHeart", $profile->getDisplayName());
        $this->assertEquals("Cegeka Guild", $profile->getClanName());
        $this->assertEquals("CGK", $profile->getClanTag());
        $this->assertEquals("/profile/2048419/1/LionHeart/", $profile->getProfilePath());

        // Portrait verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\PlayerPortrait', $profile->getPortrait());
        $portrait = $profile->getPortrait();
        $this->assertEquals(-270, $portrait->getXCoordinate());
        $this->assertEquals(-180, $portrait->getYCoordinate());
        $this->assertEquals(90, $portrait->getWidth());
        $this->assertEquals(90, $portrait->getHeight());
        $this->assertEquals(15, $portrait->getOffset());
        $this->assertEquals("http://media.blizzard.com/sc2/portraits/1-90.jpg", $portrait->getUrl());

        // Career verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\PlayerCareer', $profile->getCareer());
        $career = $profile->getCareer();
        $this->assertEquals("TERRAN", $career->getPrimaryRace());
        $this->assertEquals("GOLD", $career->getLeague());
        $this->assertEquals(106, $career->getTerranWins());
        $this->assertEquals(0, $career->getProtossWins());
        $this->assertEquals(0, $career->getZergWins());
        $this->assertEquals("PLATINUM", $career->getHighest1v1Rank());
        $this->assertEquals("DIAMOND", $career->getHighestTeamRank());
        $this->assertEquals(160, $career->getSeasonTotalGames());
        $this->assertEquals(1534, $career->getCareerTotalGames());

        // Swarm levels verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\PlayerSwarmLevels', $profile->getSwarmLevels());
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel', $profile->getSwarmLevels()->getTerranLevel());
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel', $profile->getSwarmLevels()->getProtossLevel());
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel', $profile->getSwarmLevels()->getZergLevel());
        $this->assertEquals(35, $profile->getSwarmLevels()->getPlayerLevel());

        $terranSwarmLevel = $profile->getSwarmLevels()->getTerranLevel();
        $protossSwarmLevel = $profile->getSwarmLevels()->getProtossLevel();
        $zergSwarmLevel = $profile->getSwarmLevels()->getZergLevel();

        $this->assertEquals(35, $terranSwarmLevel->getLevel());
        $this->assertEquals(5850000, $terranSwarmLevel->getTotalLevelXp());
        $this->assertEquals(-1, $terranSwarmLevel->getCurrentLevelXp());

        $this->assertEquals(0, $protossSwarmLevel->getLevel());
        $this->assertEquals(5000, $protossSwarmLevel->getTotalLevelXp());
        $this->assertEquals(0, $protossSwarmLevel->getCurrentLevelXp());

        $this->assertEquals(0, $zergSwarmLevel->getLevel());
        $this->assertEquals(5000, $zergSwarmLevel->getTotalLevelXp());
        $this->assertEquals(0, $zergSwarmLevel->getCurrentLevelXp());

        // Campaign verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\PlayerCampaign', $profile->getCampaign());
        $campaign = $profile->getCampaign();
        $this->assertEquals('CASUAL', $campaign->getWingsOfLibertyStatus());
        $this->assertNull($campaign->getHeartOfTheSwarmStatus());

        // Season verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\PlayerSeason', $profile->getSeason());
        $season = $profile->getSeason();

        foreach ($season->getStats() as $stats) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\SeasonStats', $stats);
        }

        $this->assertEquals(17, $season->getSeasonId());
        $this->assertEquals(160, $season->getTotalGamesThisSeason());
        $this->assertEquals(1, $season->getSeasonNumber());
        $this->assertEquals(2014, $season->getSeasonYear());

        $seasonStats = $season->getStats();
        $season1v1 = $seasonStats[0];
        $season2v2 = $seasonStats[1];

        $this->assertEquals('1v1', $season1v1->getType());
        $this->assertEquals(52, $season1v1->getWins());
        $this->assertEquals(73, $season1v1->getGames());

        $this->assertEquals('2v2', $season2v2->getType());
        $this->assertEquals(26, $season2v2->getWins());
        $this->assertEquals(45, $season2v2->getGames());
    }
}