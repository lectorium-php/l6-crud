<?php


namespace App\Event;


use App\Entity\Course;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class BeforeListener
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

        $this->logger->info('Event postPersist before CourseListener was triggered', ['course_id' => $entity->getId()]);
    }
}
