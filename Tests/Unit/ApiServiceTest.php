<?php

namespace petrepatrasc\BlizzardApiBundle\Tests\Unit;

use petrepatrasc\BlizzardApiBundle\Entity;
use petrepatrasc\BlizzardApiBundle\Service\ApiService;

class ApiServiceTest extends \PHPUnit_Framework_TestCase
{
    const MOCK_PATH = './Resources/mocks/';

    /**
     * @var ApiService
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

        $this->apiService = new ApiService($this->callServiceMock);
    }

    public function testGetPlayerProfileLionHeart()
    {
        $this->callServiceMock->expects($this->atLeastOnce())->method('makeCallToApiService')->withAnyParameters()->will($this->returnValue(file_get_contents(self::MOCK_PATH . 'profile-retrieval-lionheart.json')));
        $profile = $this->apiService->getPlayerProfile(Entity\Region::Europe, 2048419, 'LionHeart');

        // Player general verification
        $this->assertEquals(2048419, $profile->getBasicInformation()->getId());
        $this->assertEquals(1, $profile->getBasicInformation()->getRealm());
        $this->assertEquals("LionHeart", $profile->getBasicInformation()->getDisplayName());
        $this->assertEquals("Cegeka Guild", $profile->getBasicInformation()->getClanName());
        $this->assertEquals("CGK", $profile->getBasicInformation()->getClanTag());
        $this->assertEquals("/profile/2048419/1/LionHeart/", $profile->getBasicInformation()->getProfilePath());

        // Portrait verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Icon', $profile->getPortrait());
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
         * @var $season1v1 Entity\SeasonStats
         * @var $season2v2 Entity\SeasonStats
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
         * @var $entry Entity\Achievement
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
        $profile = $this->apiService->getPlayerProfile(Entity\Region::US, 999000, 'DayNine');

        // Player general verification
        $this->assertEquals(999000, $profile->getBasicInformation()->getId());
        $this->assertEquals(1, $profile->getBasicInformation()->getRealm());
        $this->assertEquals("DayNine", $profile->getBasicInformation()->getDisplayName());
        $this->assertEquals("Team 9", $profile->getBasicInformation()->getClanName());
        $this->assertEquals("Nine", $profile->getBasicInformation()->getClanTag());
        $this->assertEquals("/profile/999000/1/DayNine/", $profile->getBasicInformation()->getProfilePath());

        // Portrait verification
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Icon', $profile->getPortrait());
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
         * @var $entry Entity\Achievement
         */
        foreach ($achievementsArray as $entry) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Achievement', $entry);
            $this->assertInstanceOf('\DateTime', $entry->getCompletionDate());
            $this->assertInternalType('int', $entry->getAchievementId());
        }
    }

    public function testGetPlayerLatestMatches()
    {
        $this->callServiceMock->expects($this->atLeastOnce())->method('makeCallToApiService')->withAnyParameters()->will($this->returnValue(file_get_contents(self::MOCK_PATH . 'profile-retrieval-lionheart-matches.json')));
        $matches = $this->apiService->getPlayerLatestMatches(Entity\Region::Europe, 2048419, 'LionHeart');

        // Do a general data check.
        $this->assertGreaterThan(0, count($matches));

        /**
         * @var $match Entity\Match
         * @var $latestMatch Entity\Match
         */
        foreach ($matches as $match) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Match', $match);
            $this->assertInternalType('string', $match->getMap());
            $this->assertInternalType('string', $match->getType());
            $this->assertInternalType('string', $match->getDecision());
            $this->assertInternalType('string', $match->getSpeed());
            $this->assertInstanceOf('\DateTime', $match->getDate());
        }

        // Now validate that latest match to make sure that it is indeed valid.
        $latestMatch = $matches[0];
        $this->assertEquals('Heavy Rain LE', $latestMatch->getMap());
        $this->assertEquals('SOLO', $latestMatch->getType());
        $this->assertEquals('WIN', $latestMatch->getDecision());
        $this->assertEquals('FASTER', $latestMatch->getSpeed());
    }

    /**
     * @param string $region
     * @param string $mockFile
     * @param string $method
     * @param mixed $identifier
     * @param $expectedObject
     * @dataProvider grandmasterLeagueInformationDataProvider
     */
    public function testGetGrandmasterLeagueInformation($region, $mockFile, $method, $identifier = false, $expectedObject)
    {
        $this->callServiceMock->expects($this->atLeastOnce())->method('makeCallToApiService')->withAnyParameters()->will($this->returnValue(file_get_contents(self::MOCK_PATH . $mockFile)));
        $ladderMembers = $this->apiService->$method($region, $identifier);

        /**
         * @var $member Entity\Ladder\Position
         */
        foreach ($ladderMembers as $member) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Ladder\Position', $member);
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Basic', $member->getCharacter());

            $this->assertNotNull($member->getJoinDate());
            $this->assertNotNull($member->getPoints());
            $this->assertNotNull($member->getWins());
            $this->assertNotNull($member->getLosses());
            $this->assertNotNull($member->getHighestRank());
            $this->assertNotNull($member->getHighestRank());

            $this->assertNotNull($member->getJoinDate());
            $this->assertInstanceOf('\DateTime', $member->getJoinDate());
            $this->assertInternalType('float', $member->getPoints());
            $this->assertInternalType('int', $member->getWins());
            $this->assertInternalType('int', $member->getLosses());
            $this->assertInternalType('int', $member->getHighestRank());
            $this->assertInternalType('int', $member->getPreviousRank());
        }

        $this->assertEquals($expectedObject, $ladderMembers[0]);
    }

    public function grandmasterLeagueInformationDataProvider()
    {
        // Current season member
        $currentSeasonMemberToCheck = new Entity\Ladder\Position();
        $character = new Entity\Player\Basic();
        $character->setId(4685683)
            ->setRealm(1)
            ->setDisplayName("IIIIIIIIIIII")
            ->setClanName('')
            ->setClanTag('')
            ->setProfilePath('/profile/4685683/1/IIIIIIIIIIII/');

        $joinDate = new \DateTime();
        $joinDate->setTimestamp(1392756107);

        $currentSeasonMemberToCheck->setCharacter($character)
            ->setJoinDate($joinDate)
            ->setPoints(2781.0)
            ->setWins(200)
            ->setLosses(101)
            ->setHighestRank(1)
            ->setPreviousRank(18)
            ->setFavoriteRaceP1("PROTOSS");

        // Previous season member
        $previousSeasonMemberToCheck = new Entity\Ladder\Position();
        $character = new Entity\Player\Basic();
        $character->setId(4149248)
            ->setRealm(1)
            ->setDisplayName("JJAKJI")
            ->setClanName('mYinsanity')
            ->setClanTag('mYi')
            ->setProfilePath('/profile/4149248/1/JJAKJI/');

        $joinDate = new \DateTime();
        $joinDate->setTimestamp(1385578333);

        $previousSeasonMemberToCheck->setCharacter($character)
            ->setJoinDate($joinDate)
            ->setPoints(2323.0)
            ->setWins(200)
            ->setLosses(36)
            ->setHighestRank(1)
            ->setPreviousRank(1)
            ->setFavoriteRaceP1("TERRAN");

        // Player ladder information
        $playerLadderInformation = new Entity\Ladder\Position();
        $character = new Entity\Player\Basic();
        $character->setId(2048419)
            ->setRealm(1)
            ->setDisplayName("LionHeart")
            ->setClanName('Cegeka Guild')
            ->setClanTag('CGK')
            ->setProfilePath('/profile/2048419/1/LionHeart/');

        $joinDate = new \DateTime();
        $joinDate->setTimestamp(1391555842);

        $playerLadderInformation->setCharacter($character)
            ->setJoinDate($joinDate)
            ->setPoints(1111.0)
            ->setWins(56)
            ->setLosses(23)
            ->setHighestRank(1)
            ->setPreviousRank(1)
            ->setFavoriteRaceP1("TERRAN");

        return array(
            array(Entity\Region::Europe, 'ladder-grandmaster.json', 'getGrandmasterLeagueInformation', false, $currentSeasonMemberToCheck),
            array(Entity\Region::Europe, 'ladder-grandmaster-last.json', 'getGrandmasterLeagueInformation', true, $previousSeasonMemberToCheck),
            array(Entity\Region::Europe, 'ladder-information.json', 'getLeagueInformation', 151146, $playerLadderInformation),
        );
    }

    public function testGetPlayerLaddersInformation()
    {
        $this->callServiceMock->expects($this->atLeastOnce())->method('makeCallToApiService')->withAnyParameters()->will($this->returnValue(file_get_contents(self::MOCK_PATH . 'profile-retrieval-lionheart-ladders.json')));
        $ladderInformation = $this->apiService->getPlayerLaddersInformation(Entity\Region::Europe, 2048419, 'LionHeart');

        // Assert types for sanity
        $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Ladder', $ladderInformation);
        $this->assertInternalType('array', $ladderInformation->getCurrentSeason());
        $this->assertInternalType('array', $ladderInformation->getPreviousSeason());
        $this->assertInternalType('array', $ladderInformation->getShowcasePlacement());

        /**
         * @var $currentSeasonEntry Entity\Season\Entry
         * @var $previousSeasonEntry Entity\Season\Entry
         * @var $showcasePlacementEntry Entity\Season\Entry
         */

        // Assert one entry from current season.
        $temp = $ladderInformation->getCurrentSeason();
        $currentSeasonEntry = $temp[0];
        $this->assertPlayerLaddersCurrentSeason($currentSeasonEntry);

        // Assert one entry from previous season.
        $temp = $ladderInformation->getPreviousSeason();
        $previousSeasonEntry = $temp[0];

        // Assert one entry from showcase placement.

        $temp = $ladderInformation->getShowcasePlacement();
        $showcasePlacementEntry = $temp[0];
    }

    /**
     * @param Entity\Season\Entry $currentSeasonEntry
     */
    protected function assertPlayerLaddersCurrentSeason($currentSeasonEntry)
    {
        /**
         * @var $ladderInformation Entity\Ladder\Information
         * @var $characterInformation Entity\Player\Basic
         * @var $nonRanked array
         */

        $temp = $currentSeasonEntry->getLadderInformation();
        $ladderInformation = $temp[0];

        $this->assertEquals("Archon Kappa", $ladderInformation->getLadderName());
        $this->assertEquals(152724, $ladderInformation->getLadderId());
        $this->assertEquals(124, $ladderInformation->getDivision());
        $this->assertEquals(77, $ladderInformation->getRank());
        $this->assertEquals("SILVER", $ladderInformation->getLeague());
        $this->assertEquals("HOTS_TWOS", $ladderInformation->getMatchMakingQueue());
        $this->assertEquals(4, $ladderInformation->getWins());
        $this->assertEquals(6, $ladderInformation->getLosses());
        $this->assertTrue($ladderInformation->getShowcase());

        $temp = $currentSeasonEntry->getCharacters();
        $characterInformation = $temp[1];

        $this->assertEquals(3690427, $characterInformation->getId());
        $this->assertEquals(1, $characterInformation->getRealm());
        $this->assertEquals("Kodran", $characterInformation->getDisplayName());
        $this->assertEquals("Cegeka Guild", $characterInformation->getClanName());
        $this->assertEquals("CGK", $characterInformation->getClanTag());
        $this->assertEquals("/profile/3690427/1/Kodran/", $characterInformation->getProfilePath());

        $nonRanked = $currentSeasonEntry->getNonRanked();
        $this->assertInternalType('array', $nonRanked);
        $this->assertCount(0, $nonRanked);
    }

    public function testGetRewardsInformationData()
    {
        $this->callServiceMock->expects($this->atLeastOnce())->method('makeCallToApiService')->withAnyParameters()->will($this->returnValue(file_get_contents(self::MOCK_PATH . 'rewards-information.json')));
        $rewardsInformation = $this->apiService->getRewardsInformation(Entity\Region::Europe);

        /**
         * @var $portrait Entity\Reward\Portrait
         * @var $terranDecal Entity\Reward\Decal
         * @var $zergDecal Entity\Reward\Decal
         * @var $protossDecal Entity\Reward\Decal
         * @var $animation Entity\Reward\Animation
         * @var $skin Entity\Reward\Skin
         */

        // Check portrait
        $temp = $rewardsInformation->getPortraits();
        $portrait = $temp[0];

        $this->assertEquals("Kachinsky", $portrait->getTitle());
        $this->assertEquals(2951153716, $portrait->getId());
        $this->assertEquals(0, $portrait->getIcon()->getXCoordinate());
        $this->assertEquals(0, $portrait->getIcon()->getYCoordinate());
        $this->assertEquals(90, $portrait->getIcon()->getWidth());
        $this->assertEquals(90, $portrait->getIcon()->getHeight());
        $this->assertEquals(0, $portrait->getIcon()->getOffset());
        $this->assertEquals("http://media.blizzard.com/sc2/portraits/0-90.jpg", $portrait->getIcon()->getUrl());
        $this->assertEquals(0, $portrait->getAchievementId());

        // Check terran decal
        $temp = $rewardsInformation->getTerranDecals();
        $terranDecal = $temp[0];

        $this->assertEquals("Akilae Tribe", $terranDecal->getTitle());
        $this->assertEquals(3441709157, $terranDecal->getId());
        $this->assertEquals(0, $terranDecal->getIcon()->getXCoordinate());
        $this->assertEquals(-225, $terranDecal->getIcon()->getYCoordinate());
        $this->assertEquals(75, $terranDecal->getIcon()->getWidth());
        $this->assertEquals(75, $terranDecal->getIcon()->getHeight());
        $this->assertEquals(24, $terranDecal->getIcon()->getOffset());
        $this->assertEquals("http://media.blizzard.com/sc2/decals/0-75.jpg", $terranDecal->getIcon()->getUrl());
        $this->assertEquals(0, $terranDecal->getAchievementId());

        // Check zerg decal
        $temp = $rewardsInformation->getZergDecals();
        $zergDecal = $temp[0];

        $this->assertEquals("Akilae Tribe", $zergDecal->getTitle());
        $this->assertEquals(1187203361, $zergDecal->getId());
        $this->assertEquals(-150, $zergDecal->getIcon()->getXCoordinate());
        $this->assertEquals(-225, $zergDecal->getIcon()->getYCoordinate());
        $this->assertEquals(75, $zergDecal->getIcon()->getWidth());
        $this->assertEquals(75, $zergDecal->getIcon()->getHeight());
        $this->assertEquals(26, $zergDecal->getIcon()->getOffset());
        $this->assertEquals("http://media.blizzard.com/sc2/decals/0-75.jpg", $zergDecal->getIcon()->getUrl());
        $this->assertEquals(0, $zergDecal->getAchievementId());

        // Check protoss decal
        $temp = $rewardsInformation->getProtossDecals();
        $protossDecal = $temp[0];

        $this->assertEquals("Akilae Tribe", $protossDecal->getTitle());
        $this->assertEquals(2009110693, $protossDecal->getId());
        $this->assertEquals(-75, $protossDecal->getIcon()->getXCoordinate());
        $this->assertEquals(-225, $protossDecal->getIcon()->getYCoordinate());
        $this->assertEquals(75, $protossDecal->getIcon()->getWidth());
        $this->assertEquals(75, $protossDecal->getIcon()->getHeight());
        $this->assertEquals(25, $protossDecal->getIcon()->getOffset());
        $this->assertEquals("http://media.blizzard.com/sc2/decals/0-75.jpg", $protossDecal->getIcon()->getUrl());
        $this->assertEquals(0, $protossDecal->getAchievementId());

        // Check skin
        $temp = $rewardsInformation->getSkins();
        $skin = $temp[0];

        $this->assertEquals("Default", $skin->getTitle());
        $this->assertEquals("Thor", $skin->getName());
        $this->assertEquals(3979921667, $skin->getId());
        $this->assertEquals(0, $skin->getIcon()->getXCoordinate());
        $this->assertEquals(-150, $skin->getIcon()->getYCoordinate());
        $this->assertEquals(75, $skin->getIcon()->getWidth());
        $this->assertEquals(75, $skin->getIcon()->getHeight());
        $this->assertEquals(18, $skin->getIcon()->getOffset());
        $this->assertEquals("http://media.blizzard.com/sc2/skins/0-75.jpg", $skin->getIcon()->getUrl());
        $this->assertEquals(0, $skin->getAchievementId());

        // Check animation
        $temp = $rewardsInformation->getAnimations();
        $animation = $temp[0];

        $this->assertEquals("Marauder", $animation->getTitle());
        $this->assertEquals("/dance", $animation->getCommand());
        $this->assertEquals(3065782512, $animation->getId());
        $this->assertEquals(0, $animation->getIcon()->getXCoordinate());
        $this->assertEquals(0, $animation->getIcon()->getYCoordinate());
        $this->assertEquals(75, $animation->getIcon()->getWidth());
        $this->assertEquals(75, $animation->getIcon()->getHeight());
        $this->assertEquals(0, $animation->getIcon()->getOffset());
        $this->assertEquals("http://media.blizzard.com/sc2/animations/0-75.jpg", $animation->getIcon()->getUrl());
        $this->assertEquals(0, $animation->getAchievementId());
    }

    public function testGetAchievementsInformationData()
    {
        $this->callServiceMock->expects($this->atLeastOnce())->method('makeCallToApiService')->withAnyParameters()->will($this->returnValue(file_get_contents(self::MOCK_PATH . 'achievement-information.json')));
        $achievementsInformation = $this->apiService->getAchievementsInformation(Entity\Region::Europe);

        /**
         * @var $achievement Entity\Achievement\Standard
         * @var $category Entity\Achievement\Category
         * @var $child Entity\Achievement\Minimised
         */

        // Check achievement
        $temp = $achievementsInformation->getAchievements();
        $achievement = $temp[0];

        $this->assertEquals("FFA Destroyer", $achievement->getTitle());
        $this->assertEquals("Win a Free-For-All Unranked game as each race option.", $achievement->getDescription());
        $this->assertEquals(91475320766632, $achievement->getAchievementId());
        $this->assertEquals(4325391, $achievement->getCategoryId());
        $this->assertEquals(10, $achievement->getPoints());

        $this->assertEquals(0, $achievement->getIcon()->getXCoordinate());
        $this->assertEquals(-375, $achievement->getIcon()->getYCoordinate());
        $this->assertEquals(75, $achievement->getIcon()->getWidth());
        $this->assertEquals(75, $achievement->getIcon()->getHeight());
        $this->assertEquals(45, $achievement->getIcon()->getOffset());
        $this->assertEquals("http://media.blizzard.com/sc2/achievements/5-75.jpg", $achievement->getIcon()->getUrl());

        // Check category
        $temp = $achievementsInformation->getCategories();
        $category = $temp[0];

        $this->assertEquals("Liberty Campaign", $category->getMinimisedAchievement()->getTitle());
        $this->assertEquals(4325379, $category->getMinimisedAchievement()->getCategoryId());
        $this->assertEquals(91475320766734, $category->getMinimisedAchievement()->getFeaturedAchievementId());
        $this->assertEquals(8, count($category->getChildren()));

        $temp = $category->getChildren();
        $child = $temp[0];

        $this->assertEquals("Mar Sara Missions", $child->getTitle());
        $this->assertEquals(3211278, $child->getCategoryId());
        $this->assertEquals(0, $child->getFeaturedAchievementId());
    }

    /**
     * @expectedException \petrepatrasc\BlizzardApiBundle\Entity\Exception\BlizzardApiException
     */
    public function testMakeCallWhenExceptionIsHit() {
        $this->callServiceMock->expects($this->atLeastOnce())->method('makeCallToApiService')->withAnyParameters()->will($this->returnValue(file_get_contents(self::MOCK_PATH . 'resource-not-found.json')));
        $callResponse = $this->apiService->makeCall(Entity\Region::Europe, ApiService::API_REWARDS_METHOD, array(), false);
    }
}