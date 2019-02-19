<?php

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use App\Entity\User;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use GuzzleHttp\Client;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class FixtureAwareBaseTestCase extends KernelTestCase
{
    const TEST_USER_PASSWORD = "test123";
    const TEST_USER_EMAIL = "test.user@test.com";

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var ORMExecutor
     */
    private $fixtureExecutor;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var ContainerAwareLoader
     */
    private $fixtureLoader;

    public function setUp()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'http://ecsoonweb.loc/',
            'exceptions' => true
        ]);

        self::bootKernel();
        $this->em = self::$kernel->getContainer()->get('doctrine')->getManager();

        $this->addFixture(new AppFixtures());
        $this->executeFixtures();
    }

    /**
     * Adds a new fixture to be loaded.
     *
     * @param FixtureInterface $fixture
     */
    protected function addFixture(FixtureInterface $fixture)
    {
        $this->getFixtureLoader()->addFixture($fixture);
    }

    /**
     * Executes all the fixtures that have been loaded so far.
     */
    protected function executeFixtures()
    {
        $this->getFixtureExecutor()->execute($this->getFixtureLoader()->getFixtures());
    }

    /**
     * @return ORMExecutor
     */
    private function getFixtureExecutor()
    {
        if (!$this->fixtureExecutor) {
            $this->fixtureExecutor = new ORMExecutor($this->em, new ORMPurger($this->em));
        }

        return $this->fixtureExecutor;
    }

    /**
     * @return ContainerAwareLoader
     */
    private function getFixtureLoader()
    {
        if (!$this->fixtureLoader) {
            $this->fixtureLoader = new ContainerAwareLoader(self::$kernel->getContainer());
        }

        return $this->fixtureLoader;
    }

    protected function getValidToken()
    {
        $authService = self::$container->get('App\Service\JwtAuthenticationService');
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => SELF::TEST_USER_EMAIL]);

        return $authService->generateToken($user);
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}
