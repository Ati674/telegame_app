<?php


namespace App\Manager;

use App\Entity\Tirage;
use App\Repository\TirageRepository;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TirageManager
 * @package App\Manager
 */
class TirageManager extends BaseManager
{
    /**
     * PageManager constructor.
     * @param EntityManagerInterface $entityManager
     * @throws InvalidArgumentException
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Tirage::class);
        if (!$this->objectRepository instanceof TirageRepository) {
            throw new InvalidArgumentException(sprintf(
                'The repository class for "%s" must be "%s" and given "%s"! ' .
                'Maybe look the "repositoryClass" declaration on %s ?',
                Tirage::class,
                TirageRepository::class,
                get_class($this->objectRepository),
                Tirage::class
            ));
        }
    }

    /**
     * @param Tirage $tirage
     * @param bool $flush
     */
    public function createOrUpdate(Tirage $tirage, bool $flush = true): void
    {
        /** @var int|null */
        $id = $tirage->getId();
        if ($id === null) {
            $this->persist($tirage);
        }
        if ($flush === true) {
            $this->flush();
        }
    }

    /**
     * @return Tirage
     */
    public function activeParticipant(): Tirage
    {
        return $this->getObjectRepository()->getActiveParticipant();
    }
}
