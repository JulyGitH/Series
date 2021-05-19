<?php

namespace App\Controller;

use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 * @Route("/", name="main_")
 */
class MainController extends AbstractController
{

    /**
     * @Route("", name="home")
     */
    public function home()
    {
        return $this -> render('main/home.html.twig');
    }

    /**
     * @Route("test", name="test")
     */
    public function test(EntityManagerInterface $entityManager)
    {
        //$entityManager = $this->getDoctrine()->getManager();

        $uneSerie = new Serie();

        $uneSerie   ->setName('Lucky Luke')
                    ->setGenre('western')
                    ->setFirstAirDate(new \datetime('-1 year'))
                    ->setLastAirDate(new \datetime('-6 month'))
                    ->setStatus('returning')
                    ->setPopularity(100.8)
                    ->setDateCreated(new \datetime)
                    ->setPoster('kjedsfhdrtkjf')
                    ->setVote(9.8)
                    ->setTmdbId(12345);

        dump($uneSerie);

        $entityManager->persist($uneSerie);
        $entityManager->flush();

        $uneSerie->setName('Calamity Jane');
        $entityManager->persist($uneSerie);
        $entityManager->flush();

        dump($uneSerie);

        $entityManager->remove($uneSerie);
        $entityManager->flush();

        return $this -> render('main/test.html.twig', [

        ]);
    }

}