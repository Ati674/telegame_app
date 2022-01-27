<?php


namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class BaseManager
 * @package App\Manager
 */
abstract class BaseManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ObjectRepository<mixed>
     */
    protected $objectRepository;

    /**
     * BaseManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param string|mixed $className
     */
    public function __construct(EntityManagerInterface $entityManager, $className)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $entityManager->getRepository($className);
    }

    /**
     * @param object $entity
     */
    public function persist($entity) : void
    {
        $this->entityManager->persist($entity);
    }

    /**
     * Flush into database
     */
    public function flush() : void
    {
        $this->entityManager->flush();
    }

    /**
     * Force id
     *
     * @param object $entity
     */
    public function forcedId(object $entity) : void
    {
        /** @var ClassMetadataInfo $metadata */
        $metadata = $this->entityManager->getClassMetaData(get_class($entity));
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $metadata->setIdGenerator(new AssignedGenerator());
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function findById($id): ?object
    {
        if (!$id) {
            return null;
        }
        return $this->objectRepository->find($id);
    }

    /**
     * @param array $entityParams
     * @return object|null
     */
    public function findOneBy(array $entityParams): ?object
    {
        return $this->objectRepository->findOneBy($entityParams);
    }

    /**
     * @return object[]
     */
    public function findAll(): array
    {
        return $this->objectRepository->findAll();
    }

    /**
     * @param array $entityParams
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return object[]
     */
    public function findBy(array $entityParams, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->objectRepository->findBy($entityParams);
    }

    /**
     * @return ObjectRepository
     */
    public function getObjectRepository(): ObjectRepository
    {
        return $this->objectRepository;
    }

    /**
     * @param object $entity
     * @param bool $flush
     */
    public function remove(object $entity, bool $flush = true): void
    {
        $this->entityManager->remove($entity);
        if ($flush === true) {
            $this->entityManager->flush();
        }
    }
}
