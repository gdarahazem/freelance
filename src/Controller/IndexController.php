<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="Animal_list")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, AnimalRepository $animalRepository): Response
    {
        return $this->render('animal/index.html.twig', [
            'animals' => $animalRepository->findAll(),
        ]);
    }

}
