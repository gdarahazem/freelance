<?php

namespace App\Controller;

use App\Entity\Race;
use App\Form\Race1Type;
use App\Repository\RaceRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/race")
 */
class RaceController extends AbstractController
{
    /**
     * @Route("/", name="race_index", methods={"GET"})
     * @param RaceRepository $raceRepository
     * @return Response
     */
    public function index(RaceRepository $raceRepository): Response
    {
        return $this->render('race/index.html.twig', [
            'races' => $raceRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/new", name="race_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $race = new Race();
        $form = $this->createForm(Race1Type::class, $race);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($race);
            $entityManager->flush();

            return $this->redirectToRoute('race_index');
        }

        return $this->render('race/new.html.twig', [
            'race' => $race,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="race_show", methods={"GET"})
     * @param Race $race
     * @return Response
     */
    public function show(Race $race): Response
    {
        return $this->render('race/show.html.twig', [
            'race' => $race,
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/{id}/edit", name="race_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Race $race
     * @return Response
     */
    public function edit(Request $request, Race $race): Response
    {
        $form = $this->createForm(Race1Type::class, $race);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('race_index');
        }

        return $this->render('race/edit.html.twig', [
            'race' => $race,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/{id}", name="race_delete", methods={"POST"})
     * @param Request $request
     * @param Race $race
     * @return Response
     */
    public function delete(Request $request, Race $race): Response
    {
        if ($this->isCsrfTokenValid('delete' . $race->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($race);
            $entityManager->flush();
        }

        return $this->redirectToRoute('race_index');
    }
}
