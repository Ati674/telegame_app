<?php


namespace App\Controller\Admin;

use App\Entity\Tirage;
use App\Form\TirageType;
use App\Manager\ParticipantManager;
use App\Manager\TirageManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminTirageController
 * @package App\Controller\Admin
 * @Route("/tirages", name="admin_")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminTirageController extends AbstractController
{
    /**
     * @Route("/", name="tirage_index", methods={"GET"})
     */
    public function index(TirageManager $manager): Response
    {
        return $this->render('admin/tirage/index.html.twig', [
            'tirages' => $manager->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tirage_new", methods={"GET","POST"})
     */
    public function new(Request $request, TirageManager $manager, ParticipantManager $participantManager): Response
    {
        $tirage = new Tirage();
        $participants = $participantManager->findBy(array('isSubscribe' => true));
        $form = $this->createForm(TirageType::class, $tirage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($participants as $item) {
                $tirage->addParticipant($item);
            }
            $manager->createOrUpdate($tirage);

            return $this->redirectToRoute('admin_tirage_index');
        }

        return $this->render('admin/tirage/new.html.twig', [
            'tirage' => $tirage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tirage_show", methods={"GET"})
     */
    public function show(Tirage $tirage): Response
    {
        return $this->render('admin/tirage/show.html.twig', [
            'tirage' => $tirage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tirage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tirage $tirage,  TirageManager $manager): Response
    {
        $form = $this->createForm(TirageType::class, $tirage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->createOrUpdate($tirage);

            return $this->redirectToRoute('admin_tirage_index');
        }

        return $this->render('admin/tirage/edit.html.twig', [
            'tirage' => $tirage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="tirage_delete", methods={"GET","DELETE"})
     */
    public function delete(Request $request, Tirage $tirage, TirageManager $manager): Response
    {
        if (
            $this->isCsrfTokenValid('delete' . $tirage->getId(), $request->request->get('_token'))
            or $tirage->getId()
        ) {
            $manager->remove($tirage);
        }

        return $this->redirectToRoute('admin_tirage_index');
    }
}
