<?php
/**
 * Created by PhpStorm.
 *
 * This file is part of the Busybee Project.
 *
 * (c) Craig Rayner <craig@craigrayner.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * UserProvider: craig
 * Date: 23/06/2018
 * Time: 18:10
 */
namespace App\Manager\Traits;

use App\Manager\EntityInterface;
use App\Manager\MessageManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Trait EntityTrait
 * @package App\Manager
 */
trait EntityTrait
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var MessageManager
     */
    private $messageManager;

    /**
     * @var EntityRepository
     */
    static private $entityRepository;

    /**
     * @var EntityInterface
     */
    private $entity;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * EntityTrait constructor.
     * @param EntityManagerInterface $entityManager
     * @param MessageManager $messageManager
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param TranslatorInterface $translator
     * @param RouterInterface $router
     * @throws \Exception
     */
    public function __construct(EntityManagerInterface $entityManager, MessageManager $messageManager,
                                AuthorizationCheckerInterface $authorizationChecker,
                                RouterInterface $router)
    {
        $this->entityManager = $entityManager;
        $this->messageManager = $messageManager;
        self::$entityRepository = $this->getRepository();
        $this->authorizationChecker = $authorizationChecker;
        $this->router = $router;
        if (method_exists($this, 'additionalConstruct'))
            $this->additionalConstruct();
    }

    /**
     * getEntityManager
     *
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @return MessageManager
     */
    public function getMessageManager(): MessageManager
    {
        return $this->messageManager;
    }

    /**
     * find
     * @param $id
     * @return EntityInterface|null
     * @throws \Exception
     */
    public function find($id): ?EntityInterface
    {
        $this->entity = null;
        if ($id === 'Add')
            $this->entity = new $this->entityName();
        else {
            if ($this->getRepository() !== null)
                $this->entity = $this->getRepository()->find($id);
        }
        return $this->entity;
    }

    /**
     * delete
     *
     * @param $id
     * @return object
     * @throws \Exception
     */
    public function delete($id)
    {
        if ($id === 'ignore') return $this->getEntity();
        if ($id instanceof $this->entityName)
        {
            $this->setEntity($id);
            $entity = $id;
            $id = $entity->getId();
        } else
            $entity = $this->find($id);
        if (empty($entity))
        {
            $this->getMessageManager()->add('warning', 'Your request failed because your inputs were invalid.', [], 'messages');
            return $entity;
        }

        if (method_exists($this, 'canDelete')) {
            if ($this->canDelete($entity)) {
                $this->getEntityManager()->remove($entity);
                $this->getEntityManager()->flush();
                $this->getMessageManager()->add('success', 'Your request was completed successfully.', [], 'messages');
                $this->entity = null;
                return $entity;

            }
        } elseif (method_exists($entity, 'canDelete')) {
            if ($entity->canDelete()) {
                $this->getEntityManager()->remove($entity);
                $this->getEntityManager()->flush();
                $this->getMessageManager()->add('success', 'Your request was completed successfully.', [], 'messages');
                $this->entity = null;
                return $entity;
            }
        } else {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
            $this->getMessageManager()->add('success', 'Your request was completed successfully.', [], 'messages');
            $this->entity = null;
            return $entity;

        }
        $this->getMessageManager()->add('warning', 'Your request failed because your inputs were invalid.', [], 'messages');

        return $entity;
    }

    /**
     * getEntityName
     *
     * @return string
     * @throws \Exception
     */
    public function getEntityName(): string
    {
        if (empty($this->entityName))
            throw new \Exception('You nust specify the entity class [$entityName] in ' . get_class($this));
        return $this->entityName;
    }

    /**
     * getEntity
     *
     * @return null|object
     */
    public function getEntity(EntityInterface $entity = null): ?EntityInterface
    {
        if ($entity instanceof $this->entityName)
            $this->setEntity($entity);
        return $this->entity;
    }

    /**
     * @param EntityInterface|null $entity
     * @return EntityTrait
     */
    public function setEntity(?EntityInterface $entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * getTransDomain
     *
     * @return string
     */
    public function getTransDomain(): string
    {
        if(empty($this->transDomain))
            return 'messages';
        return $this->transDomain;
    }

    /**
     * saveEntity
     * @param ValidatorInterface|null $validator
     * @param bool $flush
     * @return $this
     */
    public function saveEntity(?ValidatorInterface $validator = null, bool $flush = true)
    {
        if ($validator && ($list = $validator->validate($this->getEntity()))->count() > 0)
        {
            foreach($list as $error)
                $this->getMessageManager()->add('danger', $error->getMessage(), [], false);
            return $this;
        }
        try {
            $this->getEntityManager()->persist($this->getEntity());
            if ($flush)
                $this->getEntityManager()->flush();
        } catch (\Exception $e)
        {
            $this->getMessageManager()->add('danger', 'Your request failed due to a database error.', [], false);
        }
        return $this;
    }

    /**
     * getRepository
     *
     * @param string $className
     * @return ObjectRepository|null
     * @throws \Exception
     */
    public function getRepository(?string $className = ''): ?ObjectRepository
    {
        if ($this->isValidEntityManager()) {
            $className = $className ?: $this->getEntityName();
            return $this->getEntityManager()->getRepository($className);
        }
        return null;
    }

    /**
     * @var bool|null
     */
    private $validEntityManager;

    /**
     * isValidEntityManager
     *
     * @return bool
     */
    public function isValidEntityManager(): bool
    {
        if (! is_null($this->validEntityManager))
            return $this->validEntityManager;
        return $this->validEntityManager = true;
    }

    /**
     * isValidEntity
     *
     * @return bool
     */
    public function isValidEntity(bool $entityOnly = false): bool
    {
        return $this->getEntity() instanceof $this->entityName && (intval($this->getEntity()->getId()) > 0 || $entityOnly);
    }

    /**
     * getAuthorizationChecker
     *
     * @return AuthorizationCheckerInterface
     */
    public function getAuthorizationChecker(): AuthorizationCheckerInterface
    {
        return $this->authorizationChecker;
    }

    /**
     * getTranslator
     *
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * setTranslator
     *
     * @param TranslatorInterface $translator
     * @return EntityTrait
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
        return $this;
    }

    /**
     * getRouter
     *
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    /**
     * findOneBy
     * @param array $criteria
     * @return EntityInterface|null
     * @throws \Exception
     */
    public function findOneBy(array $criteria): ?EntityInterface
    {
        $this->entity = null;
        if ($this->getRepository() !== null)
            $this->entity = $this->getRepository()->findOneBy($criteria);
        return $this->entity;
    }

    /**
     * findBy
     * @param array $criteria
     * @param array $orderBy
     * @return EntityInterface|object|null
     * @throws \Exception
     */
    public function findBy(array $criteria, array $orderBy = []): array
    {
        if ($this->getRepository() !== null)
            $results = $this->getRepository()->findBy($criteria, $orderBy);
        return $results;
    }

    /**
     * flush
     * @return $this
     */
    public function flush()
    {
        try {
            $this->getEntityManager()->flush();
        } catch (\Exception $e)
        {
            $this->getMessageManager()->add('danger', 'Your request failed due to a database error.', [], false);
        }
        return $this;
    }

    /**
     * findAsArray
     * @param EntityInterface|null $entity
     * @return array
     * @throws \Exception
     */
    public function findAsArray(?EntityInterface $entity): array
    {
        if (empty($entity))
            return [];
        $className = get_class($entity);

        if (method_exists($entity, '__toArray'))
            return $entity->__toArray();

        $result = $this->getRepository($className)->createQueryBuilder('e')
            ->select('e')
            ->where('e.id = :id')
            ->setParameter('id', $entity->getId())
            ->getQuery()
            ->getArrayResult();
        return reset($result);
    }
}
