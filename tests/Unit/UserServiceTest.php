<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use App\Service\UserService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    const TEST_USER_EMAIL = "test.user@test.com";

    /** @var UserRepositoryInterface|MockObject $teamRepositoryMock*/
    private $userRepositoryMock;

    /** @var UserService|MockObject $leagueServiceMock*/
    private $userServiceMock;

    protected function setUp()
    {
        $this->userRepositoryMock = $this->getMockBuilder(UserRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userServiceMock = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return array
     */
    public function getUserByEmailDataProvider(): array
    {
        return [
            [
                [
                    'email' => self::TEST_USER_EMAIL,
                ],
                [
                    'email' => ''
                ],
                [
                    'email' => null
                ]
            ]
        ];
    }

    /**
     * @param array $data
     * @dataProvider getUserByEmailDataProvider
     */
    public function testGetUserByEmail(array $data)
    {
        $user = new User();
        $user->setEmail($data['email']);

        $this->userRepositoryMock->expects($this->once())->method('findOneBy')->willReturn($user);
        $userService = new UserService($this->userRepositoryMock);

        $res = $userService->getUserByEmail($data['email']);

        $this->assertEquals($res->getEmail(), $data['email']);
    }
}
