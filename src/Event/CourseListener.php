<?php


namespace App\Event;


use App\Entity\Course;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class CourseListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

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

        $this->logger->info('Event was triggered', ['course_id' => $entity->getId()]);
    }
}