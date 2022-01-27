<?php

namespace App\Controller\Admin;

use App\Entity\Participant;
use App\Form\ParticipantType;
use App\Manager\ParticipantManager;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/participant", name="admin_")
 */
class AdminParticipantController extends AbstractController
{
    /**
     * @Route("/", name="participant_index", methods={"GET"})
     */
    public function index(ParticipantManager $manager): Response
    {
        return $this->render('admin/participant/index.html.twig', [
            'participants' => $manager->findAll(),
        ]);
    }

    /**
     * @Route("/participant_not_valid", name="participant_not_valid", methods={"GET"})
     */
    public function indexNotValid(ParticipantManager $manager): Response
    {
        return $this->render('admin/participant/index_not_valid.html.twig', array(
           'participants' => $manager->findBy(['isValid' => false])
        ));
    }

    /**
     * @Route("/new", name="participant_new", methods={"GET","POST"})
     */
    public function new(Request $request, ParticipantManager $manager): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participant->setUpdatedAt(new DateTime('now'));
            $manager->createOrUpdate($participant);

            return $this->redirectToRoute('admin_participant_index');
        }

        return $this->render('admin/participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participant_show", methods={"GET"})
     */
    public function show(Participant $participant): Response
    {
        return $this->render('admin/participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="participant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Participant $participant,  ParticipantManager $manager): Response
    {
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->getData()->getupdatedAt()) {
                $participant->setUpdatedAt(new DateTime('now'));
            }
            $manager->createOrUpdate($participant);

            return $this->redirectToRoute('admin_participant_index');
        }

        return $this->render('admin/participant/edit.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="participant_delete", methods={"GET","DELETE"})
     */
    public function delete(Request $request, Participant $participant, ParticipantManager $manager): Response
    {
        if (
            $this->isCsrfTokenValid('delete' . $participant->getId(), $request->request->get('_token'))
            or $participant->getId()
        ) {
            $manager->remove($participant);
        }

        return $this->redirectToRoute('admin_participant_index');
    }
}
