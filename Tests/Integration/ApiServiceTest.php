<?php

namespace petrepatrasc\BlizzardApiBundle\Tests\Integration;

use petrepatrasc\BlizzardApiBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\WebTestCase;

class ApiServiceTest extends WebTestCase
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
         * @var $member Entity\Ladder\Position
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
            array(Entity\Region::Europe, 'getGrandmasterLeagueInformation', false),
            array(Entity\Region::Europe, 'getGrandmasterLeagueInformation', true),
            array(Entity\Region::Europe, 'getLeagueInformation', 151146),
        );
    }

    public function testGetRewardsInformationData()
    {
        $information = $this->apiService->getRewardsInformationData(Entity\Region::Europe);

        /**
         * @var $portrait Entity\Reward\Portrait
         * @var $terranDecal Entity\Reward\Decal
         * @var $zergDecal Entity\Reward\Decal
         * @var $protossDecal Entity\Reward\Decal
         * @var $animation Entity\Reward\Animation
         * @var $skin Entity\Reward\Skin
         */

        foreach ($information->getPortraits() as $portrait) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Reward\Portrait', $portrait);
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Icon', $portrait->getIcon());

            $this->assertNotNull($portrait->getId());
            $this->assertNotNull($portrait->getTitle());
            $this->assertNotNull($portrait->getAchievementId());
        }

        foreach ($information->getTerranDecals() as $terranDecal) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Reward\Decal', $terranDecal);
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Icon', $terranDecal->getIcon());

            $this->assertNotNull($terranDecal->getId());
            $this->assertNotNull($terranDecal->getTitle());
            $this->assertNotNull($terranDecal->getAchievementId());
        }

        foreach ($information->getZergDecals() as $zergDecal) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Reward\Decal', $zergDecal);
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Icon', $zergDecal->getIcon());

            $this->assertNotNull($zergDecal->getId());
            $this->assertNotNull($zergDecal->getTitle());
            $this->assertNotNull($zergDecal->getAchievementId());
        }

        foreach ($information->getProtossDecals() as $protossDecal) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Reward\Decal', $protossDecal);
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Icon', $protossDecal->getIcon());

            $this->assertNotNull($protossDecal->getId());
            $this->assertNotNull($protossDecal->getTitle());
            $this->assertNotNull($protossDecal->getAchievementId());
        }

        foreach ($information->getSkins() as $skin) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Reward\Skin', $skin);
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Icon', $skin->getIcon());

            $this->assertNotNull($skin->getId());
            $this->assertNotNull($skin->getTitle());
            $this->assertNotNull($skin->getAchievementId());
        }

        foreach ($information->getAnimations() as $animation) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Reward\Animation', $animation);
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Icon', $animation->getIcon());

            $this->assertNotNull($animation->getId());
            $this->assertNotNull($animation->getTitle());
            $this->assertNotNull($animation->getAchievementId());
        }
    }

    public function testGetAchievementsInformationData()
    {
        $information = $this->apiService->getAchievementsInformationData(Entity\Region::Europe);

        /**
         * @var $achievement Entity\Achievement\Standard
         * @var $category Entity\Achievement\Category
         */

        foreach ($information->getAchievements() as $achievement) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Achievement\Standard', $achievement);
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Icon', $achievement->getIcon());

            $this->assertNotNull($achievement->getTitle());
            $this->assertNotNull($achievement->getDescription());
            $this->assertNotNull($achievement->getAchievementId());
            $this->assertNotNull($achievement->getCategoryId());
            $this->assertNotNull($achievement->getPoints());
        }

        foreach ($information->getCategories() as $category) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Achievement\Category', $category);
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Achievement\Minimised', $category->getMinimisedAchievement());

            if (!is_null($category->getChildren())) {
                foreach ($category->getChildren() as $child) {
                    $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Achievement\Minimised', $child);
                }
            }

            $this->assertNotNull($category->getMinimisedAchievement()->getTitle());
            $this->assertNotNull($category->getMinimisedAchievement()->getCategoryId());
            $this->assertNotNull($category->getMinimisedAchievement()->getFeaturedAchievementId());
        }
    }

    /**
     * @expectedException \petrepatrasc\BlizzardApiBundle\Entity\Exception\BlizzardApiException
     */
    public function testTriggerBlizzardApiException()
    {
        $player = $this->apiService->getPlayerProfile(Entity\Region::Europe, 321412, "testtesttest");
    }
}