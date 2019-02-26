<?php

namespace App\Tests\Unit;

use App\Repository\LeagueRepository;
use App\Service\LeagueService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LeagueServiceTest extends TestCase
{
    /** @var LeagueService|MockObject $leagueServiceMock*/
    private $leagueServiceMock;

    /** @var LeagueRepository|MockObject $leagueServiceMock*/
    private $leagueRepositoryMock;

    protected function setUp()
    {
        $this->leagueServiceMock = $this->getMockBuilder(LeagueService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->leagueRepositoryMock = $this->getMockBuilder(LeagueRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testLeagueExists()
    {
        $this->leagueRepositoryMock->expects($this->once())->method('find')->willReturn(1);
        $leagueService = new LeagueService($this->leagueRepositoryMock);
        $res = $leagueService->isExists(1);

        $this->assertEquals(true, $res);
    }

    public function testLeagueNotExists()
    {
        $this->leagueRepositoryMock->expects($this->once())->method('find')->willReturn(null);
        $leagueService = new LeagueService($this->leagueRepositoryMock);
        $res = $leagueService->isExists(1);

        $this->assertEquals(false, $res);
    }

}
