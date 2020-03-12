<?php


namespace App\Worker;

use App\Service\Notifier;
use Mcfedr\QueueManagerBundle\Queue\Worker;
use Mcfedr\QueueManagerBundle\Manager\QueueManagerRegistry;
use Monolog\Logger;

class EmailWorker implements Worker
{
    /**
     * @var QueueManagerRegistry
     */
    private $manager;

    /**
     * @var Notifier
     */
    private $notifier;

    public function __construct(QueueManagerRegistry $manager, Notifier $notifier)
    {
        $this->manager = $manager;
        $this->notifier = $notifier;
    }

    public function sendToQueue(string $sendTo, string $body)
    {
        return $this->manager->put('app.email_worker', ['email' => $sendTo, 'body' => $body]);
    }

    public function execute(array $arguments)
    {
        $this->notifier->notify($arguments['email'], $arguments['body']);
    }
}