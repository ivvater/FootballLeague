<?php

namespace App\Tests\Unit;

use App\Entity\League;
use App\Entity\Team;
use App\Factory\TeamFactory;
use App\Repository\TeamRepository;
use App\Service\LeagueService;
use App\Service\TeamService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TeamServiceTest extends TestCase
{
    /** @var TeamFactory|MockObject $teamRepositoryMock*/
    private $teamFactoryMock;

    /** @var TeamRepository|MockObject $teamRepositoryMock*/
    private $teamRepositoryMock;

    /** @var LeagueService|MockObject $leagueServiceMock*/
    private $leagueServiceMock;

    protected function setUp()
    {
        $this->teamFactoryMock = $this->getMockBuilder(TeamFactory::class)
            ->getMock();

        $this->teamRepositoryMock = $this->getMockBuilder(TeamRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->leagueServiceMock = $this->getMockBuilder(LeagueService::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return array
     */
    public function updateTeamDataProvider(): array
    {
        return [
            [
                [
                    'name' => 'testName',
                    'strip' => 'testStrip',
                    'league_id' => 3
                ]
            ]
        ];
    }

    /**
     * @param array $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @dataProvider updateTeamDataProvider
     */
    public function testUpdateTeam(array $data)
    {
        $league = new League();
        $league->setId($data['league_id']);

        $team = new Team();

        $this->leagueServiceMock->expects($this->once())->method('find')->willReturn($league);
        $this->teamRepositoryMock->expects($this->once())->method('save')->willReturn($team);

        $teamService = new TeamService(
            $this->teamFactoryMock,
            $this->teamRepositoryMock,
            $this->leagueServiceMock
        );

        /** @var Team $res */
        $res = $teamService->update($team, $data);

        $this->assertEquals($res->getLeague()->getId(), $data['league_id']);
        $this->assertEquals($res->getName(), $data['name']);
        $this->assertEquals($res->getStrip(), $data['strip']);
    }

    /**
     * @dataProvider updateTeamDataProvider
     * @param array $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testCreateTeam(array $data)
    {
        $league = new League();
        $league->setId($data['league_id']);

        $team = new Team();
        $team->setLeague($league);

        $this->leagueServiceMock->expects($this->once())->method('find')->willReturn($league);
        $this->teamFactoryMock->expects($this->once())->method('make')->willReturn($team);
        $this->teamRepositoryMock->expects($this->once())->method('save')->willReturn($team);

        $teamService = new TeamService(
            $this->teamFactoryMock,
            $this->teamRepositoryMock,
            $this->leagueServiceMock
        );

        /** @var Team $res */
        $res = $teamService->create($data);
        $this->assertEquals($res->getLeague()->getId(), $data['league_id']);
    }
}
