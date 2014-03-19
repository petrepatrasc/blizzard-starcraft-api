<?php

namespace petrepatrasc\BlizzardApiBundle\Tests\Unit\Service\Parsing\Ladder\Reward;

use petrepatrasc\BlizzardApiBundle\Entity\Reward\Animation;
use petrepatrasc\BlizzardApiBundle\Entity\Reward\Skin;
use petrepatrasc\BlizzardApiBundle\Service\Parsing\Reward\ResourceParsingService;

class ResourceParsingServiceTest extends \PHPUnit_Framework_TestCase
{
    protected $mockData = array(
        'title' => 'Kachinsky',
        'id' => 2951153716,
        'icon' => array(
            'x' => 0,
            'y' => 0,
            'w' => 90,
            'h' => 90,
            'offset' => 0,
            'url' => 'http =>//media.blizzard.com/sc2/portraits/0-90.jpg'
        ),
        'achievementId' => 0
    );

    /**
     * @param $mockData
     * @param $instance
     * @dataProvider extractDataProvider
     */
    public function testExtractExtensible($mockData, $instance = null)
    {
        $result = ResourceParsingService::extractExtensible($mockData, $instance);

        if (is_null($instance)) {
            $this->assertInstanceOf('\petrepatrasc\BlizzardApiBundle\Entity\Reward\Resource', $result);
        }

        $this->assertEquals($mockData['title'], $result->getTitle());
        $this->assertEquals($mockData['id'], $result->getId());
        $this->assertEquals($mockData['achievementId'], $result->getAchievementId());

        $this->assertEquals($mockData['icon']['x'], $result->getIcon()->getXCoordinate());
        $this->assertEquals($mockData['icon']['y'], $result->getIcon()->getYCoordinate());
        $this->assertEquals($mockData['icon']['w'], $result->getIcon()->getWidth());
        $this->assertEquals($mockData['icon']['h'], $result->getIcon()->getHeight());
        $this->assertEquals($mockData['icon']['offset'], $result->getIcon()->getOffset());
        $this->assertEquals($mockData['icon']['url'], $result->getIcon()->getUrl());
    }

    public function extractDataProvider()
    {
        return array(
            array($this->mockData, new Animation()),
            array($this->mockData, new Skin()),
            array($this->mockData, null)
        );
    }
}