<?php


namespace App\Event;


use App\Entity\Teacher;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;

class EntitySubscriber implements EventSubscriber
{
    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * EntityListener constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
//            Events::postPersist,
//            Events::postRemove,
            Events::postUpdate,
        ];
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Teacher) {
            return;
        }

        $this->logger->info("Event was triggered post update", ['teacher_last_name' => $entity->getLastName()]);
    }
}