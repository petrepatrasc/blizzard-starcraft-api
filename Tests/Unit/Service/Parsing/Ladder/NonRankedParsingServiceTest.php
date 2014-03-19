<?php

namespace petrepatrasc\BlizzardApiBundle\Tests\Unit\Service\Parsing\Ladder;

use \petrepatrasc\BlizzardApiBundle\Service\Parsing\Ladder;

class NonRankedParsingServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $mmq
     * @param $gamesPlayed
     * @dataProvider extractDataProvider
     */
    public function testExtract($mmq, $gamesPlayed)
    {
        $params = array(
            'mmq' => $mmq,
            'gamesPlayed' => $gamesPlayed
        );

        $result = Ladder\NonRankedParsingService::extract($params);

        $this->assertEquals($mmq, $result->getMatchMakingQueue());
        $this->assertEquals($gamesPlayed, $result->getGamesPlayed());
    }

    public function extractDataProvider()
    {
        return array(
            array('HOTS_THREES', 3),
            array(1, '3')
        );
    }
}