<?php

namespace petrepatrasc\BlizzardApiBundle\Tests\Integration;

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
        $this->assertEquals(2048419, $profile->getId());
        $this->assertEquals(1, $profile->getRealm());
        $this->assertEquals("LionHeart", $profile->getDisplayName());
        $this->assertEquals("/profile/2048419/1/LionHeart/", $profile->getProfilePath());
    }
}