<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    /**
     * @Route("/series/{page}", name="serie_list", requirements={"page"="\d+"})
     */
    public function list(int $page=1, SerieRepository $serieRepository, EntityManagerInterface $entityManager): Response
    {
        //Récupérer le repository de Serie autrement que par injection (ou Autowire)
        //$serieRepository = $this->getDoctrine()->getRepository(Serie::class);
        //$serieRepository = $entityManager->getRepository(Serie::class);

        //$series = $serieRepository->findAll();
        //$series = $serieRepository->findBy([], ["vote" => "DESC"], 50);
        $series = $serieRepository->findBestSeries($page);

        $nbSeries = $serieRepository->count([]);
        $maxPages = ceil($nbSeries/50);

        if ($page >=1 && $page <=$maxPages){
            return $this->render('serie/list.html.twig', [
                "series" => $series,
                "currentPage" => $page,
                "maxPages" => $maxPages
            ]);
        } else {
                throw $this->createNotFoundException("Ooops, this page doesn't exist !");
        }

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
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $serie = new Serie();

        $serieForm = $this->createForm(SerieType::class, $serie);
        $serie->setDateCreated(new \DateTime());

        $serieForm->handleRequest($request);

        if($serieForm->isSubmitted() && $serieForm->isValid()){

            $entityManager->persist($serie);
            $entityManager->flush();

            $this->addFlash('success', 'TV Show added!');
            return $this->redirectToRoute('serie_detail', ['id' => $serie->getId()]);

        }

        return $this->render('serie/create.html.twig', [
            'serieForm' => $serieForm->createView()
        ]);
    }


}
