<?php

namespace App\Command;

use App\Entity\Purchase;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'app:purchase-importer',
    description: 'Purchase Importer',
)]
class PurchaseImporterCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $manager,
         private UserRepository $userRepository,
         private ProductRepository $productRepository)
    {
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
                $purchasedProduct = new Purchase();
                $user=$this->userRepository->find($data[0]);
                $product=$this->productRepository->findOneBy(['sku' => $data[1]]);
                $purchasedProduct->setUser($user);
                $purchasedProduct->setProduct($product);                

                $this->manager->persist($purchasedProduct);               
            }
            $this->manager->flush();
        }
        
        $io->success('Purchased Products have been added to the database!');

        return Command::SUCCESS;
    }
}
