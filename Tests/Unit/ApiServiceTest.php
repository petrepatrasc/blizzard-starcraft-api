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
        $this->apiService->getPlayerProfile('eu', 2048419, 'LionHeart');
    }
}