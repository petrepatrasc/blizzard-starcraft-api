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
        $playerProfile = $this->apiService->getPlayerProfile('eu', 2048419, 'LionHeart');

        // Player general verification
        $this->assertEquals(2048419, $playerProfile->getId());
        $this->assertEquals(1, $playerProfile->getRealm());
        $this->assertEquals("LionHeart", $playerProfile->getDisplayName());
        $this->assertEquals("Cegeka Guild", $playerProfile->getClanName());
        $this->assertEquals("CGK", $playerProfile->getClanTag());
        $this->assertEquals("/profile/2048419/1/LionHeart/", $playerProfile->getProfilePath());

        // Portrait verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\PlayerPortrait', $playerProfile->getPortrait());
        $playerPortrait = $playerProfile->getPortrait();
        $this->assertEquals(-270, $playerPortrait->getXCoordinate());
        $this->assertEquals(-180, $playerPortrait->getYCoordinate());
        $this->assertEquals(90, $playerPortrait->getWidth());
        $this->assertEquals(90, $playerPortrait->getHeight());
        $this->assertEquals(15, $playerPortrait->getOffset());
        $this->assertEquals("http://media.blizzard.com/sc2/portraits/1-90.jpg", $playerPortrait->getUrl());

        // Career verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\PlayerCareer', $playerProfile->getCareer());
        $playerCareer = $playerProfile->getCareer();
        $this->assertEquals("TERRAN", $playerCareer->getPrimaryRace());
        $this->assertEquals("GOLD", $playerCareer->getLeague());
        $this->assertEquals(106, $playerCareer->getTerranWins());
        $this->assertEquals(0, $playerCareer->getProtossWins());
        $this->assertEquals(0, $playerCareer->getZergWins());
        $this->assertEquals("PLATINUM", $playerCareer->getHighest1v1Rank());
        $this->assertEquals("DIAMOND", $playerCareer->getHighestTeamRank());
        $this->assertEquals(160, $playerCareer->getSeasonTotalGames());
        $this->assertEquals(1534, $playerCareer->getCareerTotalGames());
    }
}