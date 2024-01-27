<?php

namespace App\Command;

use App\Entity\Product;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;



#[AsCommand(
    name: 'app:product-importer',
    description: 'Product Importer',
)]
class ProductImporterCommand extends Command
{
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('path', InputArgument::OPTIONAL, 'The path of file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $path = $input->getArgument('path');

        if (($handle = fopen($path, 'r')) !== false) {

            fgetcsv($handle, 1000, ",");
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {                
                $product = new Product();
                $product->setSku($data[0]);
                $product->setName($data[1]);

                $this->manager->persist($product);               
            }
            $this->manager->flush();
        }
        
        $io->success('Products have been added to the database!');

        return Command::SUCCESS;
    }
}
