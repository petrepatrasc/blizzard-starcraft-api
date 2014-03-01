<?php

namespace petrepatrasc\BlizzardApiBundle\Tests\Unit;

class ApiServiceTest extends \PHPUnit_Framework_TestCase
{
    const MOCK_PATH = './Resources/mocks/';

    /**
     * @var \petrepatrasc\BlizzardApiBundle\Service\ApiService
     */
    protected $apiService = null;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $callServiceMock = null;

    public function setUp()
    {
        parent::setUp();

        $this->callServiceMock = $this->getMock('CallService', array('makeCallToApiService'));

        $this->apiService = new \petrepatrasc\BlizzardApiBundle\Service\ApiService($this->callServiceMock);
    }

    public function testGetPlayerProfileLionHeart()
    {
        $this->callServiceMock->expects($this->atLeastOnce())->method('makeCallToApiService')->withAnyParameters()->will($this->returnValue(file_get_contents(self::MOCK_PATH . 'profile-retrieval-lionheart.json')));
        $profile = $this->apiService->getPlayerProfile(\petrepatrasc\BlizzardApiBundle\Entity\Region::Europe, 2048419, 'LionHeart');

        // Player general verification
        $this->assertEquals(2048419, $profile->getBasicInformation()->getId());
        $this->assertEquals(1, $profile->getBasicInformation()->getRealm());
        $this->assertEquals("LionHeart", $profile->getBasicInformation()->getDisplayName());
        $this->assertEquals("Cegeka Guild", $profile->getBasicInformation()->getClanName());
        $this->assertEquals("CGK", $profile->getBasicInformation()->getClanTag());
        $this->assertEquals("/profile/2048419/1/LionHeart/", $profile->getBasicInformation()->getProfilePath());

        // Portrait verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Portrait', $profile->getPortrait());
        $portrait = $profile->getPortrait();
        $this->assertEquals(-270, $portrait->getXCoordinate());
        $this->assertEquals(-180, $portrait->getYCoordinate());
        $this->assertEquals(90, $portrait->getWidth());
        $this->assertEquals(90, $portrait->getHeight());
        $this->assertEquals(15, $portrait->getOffset());
        $this->assertEquals("http://media.blizzard.com/sc2/portraits/1-90.jpg", $portrait->getUrl());

        // Career verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Career', $profile->getCareer());
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
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\SwarmLevels', $profile->getSwarmLevels());
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
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Campaign', $profile->getCampaign());
        $campaign = $profile->getCampaign();
        $this->assertEquals('CASUAL', $campaign->getWingsOfLibertyStatus());
        $this->assertNull($campaign->getHeartOfTheSwarmStatus());

        // Season verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Season', $profile->getSeason());
        $season = $profile->getSeason();

        foreach ($season->getStats() as $stats) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\SeasonStats', $stats);
        }

        $this->assertEquals(17, $season->getSeasonId());
        $this->assertEquals(160, $season->getTotalGamesThisSeason());
        $this->assertEquals(1, $season->getSeasonNumber());
        $this->assertEquals(2014, $season->getSeasonYear());

        $seasonStats = $season->getStats();
        $this->assertCount(2, $seasonStats);

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
        $this->assertCount(2, $seasonStats);

        // Rewards verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Rewards', $profile->getRewards());
        $rewards = $profile->getRewards();

        $expectedSelected = array(332775232, 547085114, 1202205842, 1399145799, 2665125299, 2718858952, 3837142423);
        $expectedEarned = array(97993138, 144654643, 199895074, 234481452, 332775232, 367294557, 382993515, 414497095, 493147594, 531423509, 547085114, 566530218, 615147322, 693439517, 722125123, 744177281, 836744187, 868991824, 928246938, 939528911, 964469219, 1121169820, 1127476957, 1177038943, 1179925015, 1197027376, 1202205842, 1296775413, 1307174747, 1372312663, 1399145799, 1400603187, 1516476230, 1548839636, 1605367309, 1674622116, 1702690519, 1728751618, 1750262021, 1756072743, 1807193192, 1919498533, 2119427912, 2197064007, 2212045446, 2229123380, 2270057859, 2486919067, 2562570007, 2594676792, 2636717639, 2665125299, 2674248337, 2718858952, 2785782091, 2799540787, 2825428175, 2834383599, 2951203821, 3045219362, 3133342286, 3281768270, 3313345670, 3319454886, 3404898509, 3412616780, 3429860709, 3438736930, 3587970117, 3625001715, 3759131515, 3813146549, 3821720584, 3837142423, 3851674204, 4017064141, 4051538931, 4067140795, 4125422938, 4166778254, 4179975174, 4196367769, 4229064357, 4261253982, 4265338800);

        $this->assertEquals($expectedEarned, $rewards->getEarned());
        $this->assertEquals($expectedSelected, $rewards->getSelected());

        // Achievements verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Achievements', $profile->getAchievements());
        $achievements = $profile->getAchievements();

        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Achievement\Points', $profile->getAchievements()->getPoints());
        $points = $achievements->getPoints();
        $this->assertEquals(2785, $points->getTotalPoints());

        $categoryPoints = $points->getCategoryPoints();
        $this->assertInternalType('array', $categoryPoints);
        $this->assertEquals(240, $categoryPoints["4325382"]);
        $this->assertEquals(490, $categoryPoints["4325380"]);
        $this->assertEquals(90, $categoryPoints["4325408"]);
        $this->assertEquals(1165, $categoryPoints["4325379"]);
        $this->assertEquals(0, $categoryPoints["4325410"]);
        $this->assertEquals(800, $categoryPoints["4325377"]);

        $achievementsArray = $achievements->getAchievements();
        $this->assertInternalType('array', $achievementsArray);

        /**
         * @var $entry \petrepatrasc\BlizzardApiBundle\Entity\Achievement
         */
        foreach ($achievementsArray as $entry) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Achievement', $entry);
            $this->assertInstanceOf('\DateTime', $entry->getCompletionDate());
            $this->assertInternalType('int', $entry->getAchievementId());
        }
    }

    public function testGetPlayerProfileDayJ()
    {
        $this->callServiceMock->expects($this->atLeastOnce())->method('makeCallToApiService')->withAnyParameters()->will($this->returnValue(file_get_contents(self::MOCK_PATH . 'profile-retrieval-dayj.json')));
        $profile = $this->apiService->getPlayerProfile(\petrepatrasc\BlizzardApiBundle\Entity\Region::US, 999000, 'DayNine');

        // Player general verification
        $this->assertEquals(999000, $profile->getBasicInformation()->getId());
        $this->assertEquals(1, $profile->getBasicInformation()->getRealm());
        $this->assertEquals("DayNine", $profile->getBasicInformation()->getDisplayName());
        $this->assertEquals("Team 9", $profile->getBasicInformation()->getClanName());
        $this->assertEquals("Nine", $profile->getBasicInformation()->getClanTag());
        $this->assertEquals("/profile/999000/1/DayNine/", $profile->getBasicInformation()->getProfilePath());

        // Portrait verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Portrait', $profile->getPortrait());
        $portrait = $profile->getPortrait();
        $this->assertEquals(-360, $portrait->getXCoordinate());
        $this->assertEquals(-450, $portrait->getYCoordinate());
        $this->assertEquals(90, $portrait->getWidth());
        $this->assertEquals(90, $portrait->getHeight());
        $this->assertEquals(34, $portrait->getOffset());
        $this->assertEquals("http://media.blizzard.com/sc2/portraits/0-90.jpg", $portrait->getUrl());

        // Career verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Career', $profile->getCareer());
        $career = $profile->getCareer();
        $this->assertEquals("RANDOM", $career->getPrimaryRace());
        $this->assertNull($career->getLeague());
        $this->assertEquals(0, $career->getTerranWins());
        $this->assertEquals(0, $career->getProtossWins());
        $this->assertEquals(0, $career->getZergWins());
        $this->assertEquals("PLATINUM", $career->getHighest1v1Rank());
        $this->assertEquals("MASTER", $career->getHighestTeamRank());
        $this->assertEquals(0, $career->getSeasonTotalGames());
        $this->assertEquals(268, $career->getCareerTotalGames());

        // Swarm levels verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\SwarmLevels', $profile->getSwarmLevels());
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel', $profile->getSwarmLevels()->getTerranLevel());
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel', $profile->getSwarmLevels()->getProtossLevel());
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\SwarmLevel', $profile->getSwarmLevels()->getZergLevel());
        $this->assertEquals(19, $profile->getSwarmLevels()->getPlayerLevel());

        $terranSwarmLevel = $profile->getSwarmLevels()->getTerranLevel();
        $protossSwarmLevel = $profile->getSwarmLevels()->getProtossLevel();
        $zergSwarmLevel = $profile->getSwarmLevels()->getZergLevel();

        $this->assertEquals(5, $terranSwarmLevel->getLevel());
        $this->assertEquals(125000, $terranSwarmLevel->getTotalLevelXp());
        $this->assertEquals(124122, $terranSwarmLevel->getCurrentLevelXp());

        $this->assertEquals(10, $protossSwarmLevel->getLevel());
        $this->assertEquals(155000, $protossSwarmLevel->getTotalLevelXp());
        $this->assertEquals(85501, $protossSwarmLevel->getCurrentLevelXp());

        $this->assertEquals(4, $zergSwarmLevel->getLevel());
        $this->assertEquals(105000, $zergSwarmLevel->getTotalLevelXp());
        $this->assertEquals(89800, $zergSwarmLevel->getCurrentLevelXp());

        // Campaign verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Campaign', $profile->getCampaign());
        $campaign = $profile->getCampaign();
        $this->assertEquals('BRUTAL', $campaign->getWingsOfLibertyStatus());
        $this->assertEquals('BRUTAL', $campaign->getHeartOfTheSwarmStatus());

        // Season verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Season', $profile->getSeason());
        $season = $profile->getSeason();

        foreach ($season->getStats() as $stats) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\SeasonStats', $stats);
        }

        $this->assertEquals(17, $season->getSeasonId());
        $this->assertEquals(0, $season->getTotalGamesThisSeason());
        $this->assertEquals(1, $season->getSeasonNumber());
        $this->assertEquals(2014, $season->getSeasonYear());

        $seasonStats = $season->getStats();
        $this->assertCount(0, $seasonStats);

        // Rewards verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Rewards', $profile->getRewards());
        $rewards = $profile->getRewards();

        $expectedSelected = array(18730036, 2009110693, 2359737029, 3319454886);
        $expectedEarned = array(19065053, 97993138, 171155159, 199895074, 354595443, 367294557, 382993515, 414497095, 540410724, 547085114, 595375415, 615147322, 637508413, 722125123, 744177281, 836744187, 863976264, 868991824, 983487403, 1002357867, 1034610896, 1060652497, 1079649078, 1101809667, 1177038943, 1202205842, 1232091643, 1256759101, 1330937594, 1399145799, 1435566629, 1443233935, 1453233559, 1467565626, 1542695810, 1563607663, 1686196380, 1702690519, 1716314872, 1728751618, 1750262021, 1756072743, 1798698573, 1807193192, 1919498533, 1950195664, 2069737544, 2071251289, 2113477352, 2119427912, 2184379176, 2288979736, 2419802213, 2420367594, 2449282564, 2486919067, 2584611494, 2636717639, 2646575556, 2665125299, 2710644389, 2718858952, 2730379211, 2809480242, 2825428175, 2908978867, 2951203821, 3032291021, 3045219362, 3205179785, 3247325755, 3319454886, 3492698187, 3566090531, 3587970117, 3625001715, 3630735430, 3638208774, 3688882959, 3690831617, 3692299263, 3759131515, 3821720584, 3846834130, 3918875355, 3977184535, 4017064141, 4017588258, 4130543639, 4162301223, 4179975174, 4189275055, 4196367769, 4229064357);

        $this->assertEquals($expectedEarned, $rewards->getEarned());
        $this->assertEquals($expectedSelected, $rewards->getSelected());

        // Achievements verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Achievements', $profile->getAchievements());
        $achievements = $profile->getAchievements();

        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Achievement\Points', $profile->getAchievements()->getPoints());
        $points = $achievements->getPoints();
        $this->assertEquals(3420, $points->getTotalPoints());

        $categoryPoints = $points->getCategoryPoints();
        $this->assertInternalType('array', $categoryPoints);
        $this->assertEquals(0, $categoryPoints["4325382"]);
        $this->assertEquals(80, $categoryPoints["4325380"]);
        $this->assertEquals(0, $categoryPoints["4325408"]);
        $this->assertEquals(1560, $categoryPoints["4325379"]);
        $this->assertEquals(1280, $categoryPoints["4325410"]);
        $this->assertEquals(500, $categoryPoints["4325377"]);

        $achievementsArray = $achievements->getAchievements();
        $this->assertInternalType('array', $achievementsArray);

        /**
         * @var $entry \petrepatrasc\BlizzardApiBundle\Entity\Achievement
         */
        foreach ($achievementsArray as $entry) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Achievement', $entry);
            $this->assertInstanceOf('\DateTime', $entry->getCompletionDate());
            $this->assertInternalType('int', $entry->getAchievementId());
        }
    }
}