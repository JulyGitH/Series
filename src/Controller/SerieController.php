<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    /**
     * @Route("/series", name="serie_list")
     */
    public function list(SerieRepository $serieRepository, EntityManagerInterface $entityManager): Response
    {
        //Récupérer le repository de Serie autrement que par injection (ou Autowire)
        //$serieRepository = $this->getDoctrine()->getRepository(Serie::class);
        //$serieRepository = $entityManager->getRepository(Serie::class);

        //$series = $serieRepository->findAll();
        //$series = $serieRepository->findBy([], ["vote" => "DESC"], 50);
        $series = $serieRepository->findBestSeries();

        return $this->render('serie/list.html.twig', [
            "series" => $series
        ]);




    }

    /**
     * @Route("/series/detail/{id}", name="serie_detail")
     */
    public function detail($id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);
        if(!$serie){
            throw $this->createNotFoundException("Oops, This serie doesn't exist !");
        }

        return $this->render('serie/detail.html.twig', [
            "serie" => $serie
        ]);
    }

    /**
     * @Route("/series/create", name="serie_create")
     */
    public function create(): Response
    {

        //TODO : ajouter une serie

        return $this->render('serie/create.html.twig', [

        ]);
    }


}
