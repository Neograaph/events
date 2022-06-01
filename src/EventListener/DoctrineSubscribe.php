<?php 
namespace App\EventListener;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class DoctrineSubscribe implements EventSubscriberInterface
{
    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args, UserRepository $userRepository) :void
    {
        $entity = $args->getObject();

        if ($entity instanceof User) {
            // dd($entity->getRoles());
            dd($userRepository->findAll());
        };
    }
}

?>