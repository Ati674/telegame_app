<?php

namespace App\Controller\Admin;

use App\Manager\ParticipantManager;
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

        return $this->render('admin/index.html.twig', array(
            'participants' => $participants,
            'participantsNotValid' => $participantsNotValid
        ));
    }
}
