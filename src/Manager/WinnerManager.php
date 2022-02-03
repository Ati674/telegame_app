<?php


namespace App\Manager;

use App\Entity\Winner;
use App\Repository\WinnerRepository;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class WinnerManager
 * @package App\Manager
 */
class WinnerManager extends BaseManager
{
    /**
     * PageManager constructor.
     * @param EntityManagerInterface $entityManager
     * @throws InvalidArgumentException
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Winner::class);
        if (!$this->objectRepository instanceof WinnerRepository) {
            throw new InvalidArgumentException(sprintf(
                'The repository class for "%s" must be "%s" and given "%s"! ' .
                'Maybe look the "repositoryClass" declaration on %s ?',
                Winner::class,
                WinnerRepository::class,
                get_class($this->objectRepository),
                Winner::class
            ));
        }
    }

    /**
     * @param Winner $winner
     * @param bool $flush
     */
    public function createOrUpdate(Winner $winner, bool $flush = true): void
    {
        /** @var int|null */
        $id = $winner->getId();
        if ($id === null) {
            $this->persist($winner);
        }
        if ($flush === true) {
            $this->flush();
        }
    }
}
