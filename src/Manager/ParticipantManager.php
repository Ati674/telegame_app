<?php


namespace App\Manager;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ParticipantManager
 * @package App\Manager
 */
class ParticipantManager extends BaseManager
{
    /**
     * PageManager constructor.
     * @param EntityManagerInterface $entityManager
     * @throws InvalidArgumentException
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Participant::class);
        if (!$this->objectRepository instanceof ParticipantRepository) {
            throw new InvalidArgumentException(sprintf(
                'The repository class for "%s" must be "%s" and given "%s"! ' .
                'Maybe look the "repositoryClass" declaration on %s ?',
                Participant::class,
                ParticipantRepository::class,
                get_class($this->objectRepository),
                Participant::class
            ));
        }
    }

    /**
     * @param Participant $participant
     * @param bool $flush
     */
    public function createOrUpdate(Participant $participant, bool $flush = true): void
    {
        /** @var int|null */
        $id = $participant->getId();
        if ($id === null) {
            $this->persist($participant);
        }
        if ($flush === true) {
            $this->flush();
        }
    }

    public function totalTicketNumber()
    {
        return $this->objectRepository->countTotalTicketNumber();
    }
}
