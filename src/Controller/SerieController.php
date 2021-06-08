<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\ManageEntity\UpdateEntity;
use App\Repository\SerieRepository;
use App\Upload\SerieImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/series/detail/{id}", name="serie_detail", requirements={"id"="\d+"})
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
    public function create(Request $request, UpdateEntity $updateEntity, SerieImage $serieImage): Response
    {
        $serie = new Serie();

        $serieForm = $this->createForm(SerieType::class, $serie);
        $serie->setDateCreated(new \DateTime());

        $serieForm->handleRequest($request);

        if($serieForm->isSubmitted() && $serieForm->isValid()){

            $file = $serieForm->get('poster')->getData();

            /**
             * @var UploadedFile $file
             */
            if($file){

                $directory = $this->getParameter('upload_posters_series_dir');
                $serieImage->save($file, $serie, $directory);

            }

            $updateEntity->save($serie);

            $this->addFlash('success', 'TV Show added!');
            return $this->redirectToRoute('serie_detail', ['id' => $serie->getId()]);

        }

        return $this->render('serie/create.html.twig', [
            'serieForm' => $serieForm->createView()
        ]);
    }

    /**
     * @Route("/series/edit/{id}", name="serie_edit")
     */
    public function edit($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $serie = $entityManager->find(Serie::class, $id);
        if(!$serie){
            throw $this->createNotFoundException('Ooops ! This serie does not exist!');
        }

        $serieForm = $this->createForm(SerieType::class, $serie);
        $serie->setDateModified(new \DateTime());

        $serieForm->handleRequest($request);

        if($serieForm->isSubmitted() && $serieForm->isValid()){

            $entityManager->persist($serie);
            $entityManager->flush();

            $this->addFlash('success', 'Serie has been edited');
            return $this->redirectToRoute('serie_detail', ['id' => $serie->getId()]);

        }

        return $this->render('serie/create.html.twig', [
            'serieForm' => $serieForm->createView()
        ]);
    }

    /**
     * @Route("/series/delete/{id}", name="serie_delete")
     */
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $serieToDelete = $entityManager->find(Serie::class, $id);

        $entityManager->remove($serieToDelete);
        $entityManager->flush();

        $this->addFlash('success', 'Serie has been deleted');

        return $this->redirectToRoute('serie_list');
    }

    /**
     * @Route("/series/detail/ajax_like", name="serie_ajax_like")
     */
    public function likeOrDislike(Request $request,
                                  SerieRepository $serieRepository,
                                  EntityManagerInterface $entityManager): Response
    {
        //Recup des données en requete
        $data= json_decode($request->getContent());
        $serieId = $data->serieId;
        $like = $data->like;

        //On récupère l'instance de la série en fonction de l'id
        $serie = $serieRepository->find($serieId);

        //Modif des nbLike en fonction du paramètre
        if($like == 0){
            $serie->setNbLike($serie->getNbLike()-1);
        } else {
            $serie->setNbLike($serie->getNbLike()+1);
        }

        //validation en BDD de la modification de la serie
        $entityManager->persist($serie);
        $entityManager->flush();

        //retourne un objet de type JsonResponse avec le total de likes mis à jour
        return new JsonResponse(['likes'=>$serie->getNbLike()]);

    }


}
