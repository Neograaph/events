<?php 
namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class DoctrineSubscribe implements EventSubscriberInterface
{
    protected $manager;
    protected $userRepository;
    
    public function __construct(EntityManagerInterface $manager, UserRepository $userRepository)
    {
        $this->manager = $manager;
        $this->userRepository = $userRepository;
    }
    
    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        return [
            Events::preRemove,
        ];
    }

    public function preRemove(LifecycleEventArgs $args) :void
    {
        $this->changeNewUser($args);
    }
    
    private function changeNewUser(LifecycleEventArgs $args) :void
    {
        $entity = $args->getObject();
    
        if ($entity instanceof User) {
            $lenghtArray = count($this->userRepository->findAll());

            dump($entity->getRoles());
            dump($this->userRepository->findBy(array('roles' => '[1]["ROLE_USER"]')));
            dump($this->userRepository->findBy(array('id' => 1)));
            // die;
            
            if ($lenghtArray <= 3){
                throw new Exception('<= à 3');
            }
        };
    }
}