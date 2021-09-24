<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Personne;
use App\Form\EquipeType;
use App\Form\PersonneType;
use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET","POST"})
     */
    public function home(Request $request,EquipeRepository $repository): Response
    {
        $equipe = new Equipe();
        $equipeForm = $this->createForm(EquipeType::class, $equipe);
        $equipeForm->handleRequest($request);

        $equipes = $repository -> findAll();

        if ($equipeForm->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        $personne = new Personne();
        $personneForm = $this->createForm(PersonneType::class, $personne);
        $personneForm->handleRequest($request);

        if ($personneForm->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personne);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('main/index.html.twig', [
            'equipeForm' => $equipeForm->createView(),
            'equipes' => $equipes,
            'personne' => $personne,
            'personneForm' => $personneForm->createView(),
        ]);

    }


}
