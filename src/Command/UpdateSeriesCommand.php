<?php

namespace App\Command;

use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateSeriesCommand extends Command
{
    protected static $defaultName = 'app:update-series';
    protected static $defaultDescription = 'Update series from the last 2 years';

    private $entityManager;

    public function __construct(string $name = null, EntityManagerInterface $entityManager)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            //->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


        /*
         $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }
        */

        $io->success("Bravo t'es un champion");
        $io->error("Oups c'est loupé");
        $io->writeln("I'm going to suppress all series older than 2-years-old");

        $serieRepository = $this->entityManager->getRepository(Serie::class);
        $series = $serieRepository->findAll();

        $date = new \DateTime();
        $date->modify('-2 years');

        $deletedSeries = 0;

        /**
         * @var Serie $serie
         */
        foreach($series as $serie){
            if($serie->getLastAirDate() < $date){
                $this->entityManager->remove($serie);
                $deletedSeries++;
            }
        }

        $io->success($deletedSeries.' has been removed.');

        return Command::SUCCESS;
    }
}
