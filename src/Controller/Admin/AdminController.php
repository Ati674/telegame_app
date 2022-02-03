<?php

namespace App\Controller\Admin;

use App\Entity\Winner;
use App\Manager\ParticipantManager;
use App\Manager\TirageManager;
use App\Manager\WinnerManager;
use App\Service\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 * @Route("/", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param ParticipantManager $participantManager
     * @return Response
     */
    public function index(ParticipantManager $participantManager): Response
    {
        $participants = count($participantManager->findAll());
        $participantsNotValid = count($participantManager->findBy(array('isValid' => false)));
        $totalTicketNumber = $participantManager->totalTicketNumber();

        return $this->render('admin/index.html.twig', array(
            'participants' => $participants,
            'participantsNotValid' => $participantsNotValid,
            'totalTicketNumber' => $totalTicketNumber
        ));
    }

    /**
     * @Route("/run-tirage", name="tirage_run", methods={"GET"})
     */
    public function runTirage(TirageManager $manager, WinnerManager $winnerManager, Mailer $mailer): Response
    {
        $tirage = $manager->activeParticipant();
        $participants = $tirage->getParticipants();
        $manager->createOrUpdate($tirage);
        $data = [];
        foreach ($participants as $key => $value) {
            for ($i = 0; $i <= $value->getTicketNumber(); $i++) {
                $data[] = $value;
            }
        }
        $v = array_rand($data);
        $resultat = $data[$v];
        $winner = new Winner();
        $winner->setName($resultat->getTelegram());
        $winner->setTirage($tirage);
        $winnerManager->createOrUpdate($winner);
        $datas = [
            $resultat->getName(),
            $resultat->getEmail(),
            $resultat->getTicketNumber(),
            $resultat->getTelegram()
        ];

        $mailer->sendEmail('Vous venez de gagnez un cadeau !', $resultat->getEmail(), 'winner', $datas);

        foreach ($data as $key => $value) {
            if ($resultat === $value) {
                unset($value);
            }
        }

        return $this->render('admin/tirage/run.html.twig', array(
            'winner' => $winner,
            'tirage' => $tirage
        ));
    }
}
