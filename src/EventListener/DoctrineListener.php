<?php
namespace App\EventListener;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;
use \Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpKernel\Event\RequestEvent;

class DoctrineListener
{
    protected $repo;
    public function __construct(ArticleRepository $repo)
    {
        $this->repo = $repo;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof Article)
        {
            $entity->setCreatedAt(new \DateTimeImmutable());
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if(true === property_exists($entity, 'updated_at') && $entity instanceof Article)
        {
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    public function preRemove()
    {
        $repo = $this->repo->findAll();
        if(count($repo) <= 1)
        {
            throw new \Exception('Impossible');
        }
        else
        {
            dd('possible');
        }
    }
}