<?php

namespace petrepatrasc\BlizzardApiBundle\Tests\Integration;

use petrepatrasc\BlizzardApiBundle\Entity\Ladder\Position;
use petrepatrasc\BlizzardApiBundle\Entity\Match;
use petrepatrasc\BlizzardApiBundle\Entity\Region;

class ApiServiceTest extends \Symfony\Bundle\FrameworkBundle\Tests\Functional\WebTestCase
{
    /**
     * @var \petrepatrasc\BlizzardApiBundle\Service\ApiService
     */
    protected $apiService = null;

    public function setUp()
    {
        parent::setUp();
        $callService = new \petrepatrasc\BlizzardApiBundle\Service\CallService();
        $this->apiService = new \petrepatrasc\BlizzardApiBundle\Service\ApiService($callService);
    }

    public function testGetProfileSanityCheckThatApiIsActuallyResponding()
    {
        $profile = $this->apiService->getPlayerProfile(\petrepatrasc\BlizzardApiBundle\Entity\Region::Europe, 2048419, 'LionHeart');

        // Player general verification
        $this->assertEquals(2048419, $profile->getBasicInformation()->getId());
        $this->assertEquals(1, $profile->getBasicInformation()->getRealm());
        $this->assertEquals("LionHeart", $profile->getBasicInformation()->getDisplayName());
        $this->assertEquals("/profile/2048419/1/LionHeart/", $profile->getBasicInformation()->getProfilePath());
    }

    public function testGetPlayerLatestMatches()
    {
        $matches = $this->apiService->getPlayerLatestMatches(Region::Europe, 2048419, 'LionHeart');

        // Do a general data check.
        $this->assertGreaterThan(0, count($matches));

        /**
         * @var $match Match
         * @var $latestMatch Match
         */
        foreach ($matches as $match) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Match', $match);
            $this->assertInternalType('string', $match->getMap());
            $this->assertInternalType('string', $match->getType());
            $this->assertInternalType('string', $match->getDecision());
            $this->assertInternalType('string', $match->getSpeed());
            $this->assertInstanceOf('\DateTime', $match->getDate());
        }
    }

    /**
     * @param string $region
     * @param string $method
     * @param mixed $identifier
     * @dataProvider grandmasterLeagueInformationDataProvider
     */
    public function testGetGrandmasterLeagueInformation($region, $method, $identifier)
    {
        $ladderMembers = $this->apiService->$method($region, $identifier);

        /**
         * @var $member Position
         */
        foreach ($ladderMembers as $member) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Ladder\Position', $member);
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Player\Basic', $member->getCharacter());

            // Some general checks
            $this->assertInstanceOf('\DateTime', $member->getJoinDate());
            $this->assertInternalType('float', $member->getPoints());
            $this->assertInternalType('int', $member->getHighestRank());
            $this->assertInternalType('int', $member->getWins());
            $this->assertInternalType('int', $member->getPreviousRank());
            $this->assertInternalType('int', $member->getLosses());
        }
    }

    public function grandmasterLeagueInformationDataProvider()
    {
        return array(
            array(Region::Europe, 'getGrandmasterLeagueInformation', false),
            array(Region::Europe, 'getGrandmasterLeagueInformation', true),
            array(Region::Europe, 'getLeagueInformation', 151146),
        );
    }
}