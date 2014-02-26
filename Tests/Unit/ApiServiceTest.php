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

        /**
         * @var $season1v1 \petrepatrasc\BlizzardApiBundle\Entity\SeasonStats
         * @var $season2v2 \petrepatrasc\BlizzardApiBundle\Entity\SeasonStats
         */
        $season1v1 = $seasonStats[0];
        $season2v2 = $seasonStats[1];

        $this->assertEquals('1v1', $season1v1->getType());
        $this->assertEquals(52, $season1v1->getWins());
        $this->assertEquals(73, $season1v1->getGames());

        $this->assertEquals('2v2', $season2v2->getType());
        $this->assertEquals(26, $season2v2->getWins());
        $this->assertEquals(45, $season2v2->getGames());

        // Rewards verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\PlayerRewards', $profile->getRewards());
        $rewards = $profile->getRewards();

        $expectedSelected = array(332775232, 547085114, 1202205842, 1399145799, 2665125299, 2718858952, 3837142423);
        $expectedEarned = array(97993138, 144654643, 199895074, 234481452, 332775232, 367294557, 382993515, 414497095, 493147594, 531423509, 547085114, 566530218, 615147322, 693439517, 722125123, 744177281, 836744187, 868991824, 928246938, 939528911, 964469219, 1121169820, 1127476957, 1177038943, 1179925015, 1197027376, 1202205842, 1296775413, 1307174747, 1372312663, 1399145799, 1400603187, 1516476230, 1548839636, 1605367309, 1674622116, 1702690519, 1728751618, 1750262021, 1756072743, 1807193192, 1919498533, 2119427912, 2197064007, 2212045446, 2229123380, 2270057859, 2486919067, 2562570007, 2594676792, 2636717639, 2665125299, 2674248337, 2718858952, 2785782091, 2799540787, 2825428175, 2834383599, 2951203821, 3045219362, 3133342286, 3281768270, 3313345670, 3319454886, 3404898509, 3412616780, 3429860709, 3438736930, 3587970117, 3625001715, 3759131515, 3813146549, 3821720584, 3837142423, 3851674204, 4017064141, 4051538931, 4067140795, 4125422938, 4166778254, 4179975174, 4196367769, 4229064357, 4261253982, 4265338800);

        $this->assertEquals($expectedEarned, $rewards->getEarned());
        $this->assertEquals($expectedSelected, $rewards->getSelected());
    }
}