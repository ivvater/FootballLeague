<?php

namespace App\Tests\Unit;

use App\Entity\League;
use App\Entity\Team;
use App\Response\Factory\ResponseFactory;
use App\Response\Transformer\TeamTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class ResponseFactoryTest extends TestCase
{

    public function transformerDataProvider()
    {
        $league = new League();
        $league->setId(1);

        $team = new Team();
        $team->setId(1);
        $team->setLeague($league);
        $team->setName('testName');
        $team->setStrip('testStrip');

        return [
            [
                $team
            ]
        ];
    }

    /** @dataProvider transformerDataProvider
     * @param Team $team
     */
    public function testTeamItemTransformer(Team $team)
    {
        $responseFactory = new ResponseFactory();
        $res = $responseFactory->make($team, new TeamTransformer)->toArray();

        $expectedData = [
            'id' => 1,
            'name' => 'testName',
            'strip' => 'testStrip',
            'league' => 1
        ];

        $this->assertEquals($expectedData, $res['data']);
    }

    /** @dataProvider transformerDataProvider
     * @param Team $team
     */
    public function testTeamCollectionTransformer(Team $team)
    {
        $responseFactory = new ResponseFactory();
        $res = $responseFactory->make(new ArrayCollection([$team]), new TeamTransformer)->toArray();

        $expectedData = [
            [
                'id' => 1,
                'name' => 'testName',
                'strip' => 'testStrip',
                'league' => 1
            ]
        ];

        $this->assertEquals($expectedData, $res['data']);
    }
}
