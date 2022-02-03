<?php


namespace App\Controller\Main;

use App\Entity\Participant;
use App\Form\ParticipantType;
use App\Manager\ParticipantManager;
use App\Manager\TirageManager;
use App\Manager\WinnerManager;
use App\Service\Mailer;
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
     * @param ParticipantManager $participantManager
     * @param Mailer $mailer
     * @param TirageManager $tirageManager
     * @param WinnerManager $winnerManager
     * @return Response
     */
    public function index(
        Request $request,
        ParticipantManager $participantManager,
        Mailer $mailer,
        TirageManager $tirageManager,
        WinnerManager $winnerManager
    ): Response {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);
        $tirage = $tirageManager->findOneBy(array('isActive' => true));
        $winner = $winnerManager->findOneBy(array('tirage' => $tirage));
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $participant->setIsValid(false);
                $participant->setIsSubscribe(false);
                $participant->setPaymentType('binance');
                $participant->setUpdatedAt(new \DateTime('now'));
                $participant->addTirage($tirage);
                $participantManager->createOrUpdate($participant);
                $datas = [
                    $participant->getName(),
                    $participant->getEmail(),
                    $participant->getTicketNumber(),
                    $participant->getTelegram(),
                ];

                $this->addFlash('success', 'Participation prise en compte avec succès !');
                $mailer->sendEmail('Participation prise en compte !', $participant->getEmail(), 'inscription', $datas);

                return $this->redirectToRoute('front_home');
            } catch (\Exception $exception) {
                $this->addFlash('danger', 'Un problème est survenu contacter un administateur !');
                // $this->addFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('front/index.html.twig', array(
            'tirage' => $tirage,
            'winner' => $winner
        ));
    }

    /**
     * @Route("/render-form-participate", name="render_form_participate")
     * @param Request $request
     * @return JsonResponse
     */
    public function renderFormParticipate(Request $request): JsonResponse
    {
        $response = [
            'content' => ''
        ];
        if ($request->isXmlHttpRequest()) {
            $participant = new Participant();
            $participant->setIsSubscribe(false);
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
     * @param Request $request
     * @param ParticipantManager $manager
     * @param Mailer $mailer
     * @return Response
     */
    public function doneParticipate(Request $request, ParticipantManager $manager, Mailer $mailer): Response
    {
        if ($request->isXmlHttpRequest()) {
            $participant = new Participant();
            $form = $this->createForm(ParticipantType::class, $participant);
            $form->handleRequest($request);
            $participant->setIsValid(true);
            $participant->setPaymentType('paypal');
            $participant->setIsSubscribe(true);
            $participant->setUpdatedAt(new \DateTime('now'));
            $manager->createOrUpdate($participant);
            $datas = [
                $participant->getName(),
                $participant->getEmail(),
                $participant->getTicketNumber(),
                $participant->getTelegram(),
            ];

            $this->addFlash('success', 'Participation prise en compte avec succès !');
            $mailer->sendEmail(
                'Participation prise en compte !',
                $participant->getEmail(),
                'inscription',
                $datas
            );

            return new JsonResponse('success', 200);
        }
       return new Response('error', 200);
    }
}
