<?php

namespace App\Tests;

use App\Command\TestFixturesLoaderCommand;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class AppTestCase extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    /**
     * @var Filesystem
     */
    protected $fs;

    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->doctrine = $this->client->getContainer()->get('doctrine');

        $this->fs = new Filesystem();

        if ($this->fs->exists(
            $this->client->getContainer()->getParameter('default_db_path')
        )) {
            $this->fs->copy(
                $this->client->getContainer()->getParameter('default_db_path'),
                $this->client->getContainer()->getParameter('test_db_path')
            );
        } else {
            TestFixturesLoaderCommand::runCommand(
                $this->client->getKernel(),
                ['command' => 't:f:l', '-e' => 'test', '-f' => true]
            );
        }
    }

    public function tearDown(): void
    {
        $this->fs->remove($this->client->getContainer()->getParameter('test_db_path'));
        $this->doctrine = null;
        $this->client = null;

        parent::tearDown();
    }

    protected function logIn(string $email, string $password)
    {
        $this->client->setServerParameters(['PHP_AUTH_USER' => $email, 'PHP_AUTH_PW' => $password]);
    }
}