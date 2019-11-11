<?php


namespace App\Event;


use App\Entity\Course;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class EntityListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * EntityListener constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Course) {
            return;
        }

        $this->logger->info("Event was triggered", ['course_title' => $entity->getTitle()]);
    }
}