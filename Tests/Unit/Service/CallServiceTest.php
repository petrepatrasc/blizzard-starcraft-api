<?php

namespace petrepatrasc\BlizzardApiBundle\Tests\Unit\Service;


use petrepatrasc\BlizzardApiBundle\Entity;
use petrepatrasc\BlizzardApiBundle\Service\ApiService;
use petrepatrasc\BlizzardApiBundle\Service\CallService;
use petrepatrasc\StarcraftConnectionLayerBundle\Service\ConnectionService;

class CallServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CallService
     */
    protected $callService;

    public function setUp() {
        parent::setUp();

        $this->callService = new CallService();
    }

    public function testDependencyInjection() {
        $connectivityLayer = new ConnectionService();

        $this->callService = new CallService();
        $this->callService->setConnectivityLayer($connectivityLayer);

        $this->assertEquals($connectivityLayer, $this->callService->getConnectivityLayer());
    }

    /**
     * @expectedException \petrepatrasc\BlizzardApiBundle\Entity\Exception\BlizzardApiException
     * @expectedExceptionCode 500
     * @expectedExceptionMessage No data was returned from the server
     */
    public function testNullResponseRaisesExceptions() {
        $blizzardServiceMock = $this->getMock('\petrepatrasc\StarcraftConnectionLayer\Service\BlizzardApi', array('retrieveData'));
        $blizzardServiceMock->expects($this->atLeastOnce())->method('retrieveData')->withAnyParameters()->will($this->returnValue(null));

        $connectivityLayerMock = $this->getMock('\petrepatrasc\StarcraftConnectionLayer\Service\ConnectionService', array('getBlizzardApi'));
        $connectivityLayerMock->expects($this->atLeastOnce())->method('getBlizzardApi')->withAnyParameters()->will($this->returnValue($blizzardServiceMock));

        $this->callService->setConnectivityLayer($connectivityLayerMock);

        $this->callService->makeCallToApiService(Entity\Region::Europe, ApiService::API_REWARDS_METHOD, array(), false);
    }
}