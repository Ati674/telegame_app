<?php


namespace App\Controller\Main;

use App\Entity\Participant;
use App\Form\ParticipantFileType;
use App\Form\ParticipantType;
use App\Manager\ParticipantManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FrontController
 * @package App\Controller\Main
 * @Route("/", name="front_")
 */
class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param ParticipantManager $manager
     * @return Response
     */
    public function index(Request $request, ParticipantManager $manager): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $participant->setIsValid(false);
                $participant->setUpdatedAt(new \DateTime('now'));
                $manager->createOrUpdate($participant);
                $this->addFlash('success', 'Participation prise en compte avec succès !');

                return $this->redirectToRoute('front_home');
            } catch (\Exception $exception) {
                $this->addFlash('danger', 'Un problème est survenu contacter un administateur !');
                // $this->addFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('front/index.html.twig');
    }

    /**
     * @Route("/render-form-participate", name="render_form_participate")
     */
    public function renderFormParticipate(Request $request): JsonResponse
    {
        $response = [
            'content' => ''
        ];
        if ($request->isXmlHttpRequest()) {
            $participant = new Participant();
            $form = $this->createForm(ParticipantType::class, $participant);
            $form->handleRequest($request);

            $html = $this->render('front/participant/_form.html.twig', array(
                'form' => $form->createView(),
            ));
            $response = [
                'content' => $html->getContent()
            ];
            return new JsonResponse($response, 200);
        }
        return new JsonResponse($response, 201);
    }

    /**
     * @Route("/done-participate", name="done_participate", methods={"POST"})
     */
    public function doneParticipate(Request $request, ParticipantManager $manager): Response
    {
        if ($request->isXmlHttpRequest()) {
            $participant = new Participant();
            $form = $this->createForm(ParticipantType::class, $participant);
            $form->handleRequest($request);
            $participant->setIsValid(true);
            $participant->setUpdatedAt(new \DateTime('now'));
            $manager->createOrUpdate($participant);

            return new JsonResponse('success', 200);
        }
       return new Response('error', 200);
    }



}
