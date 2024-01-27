<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;


#[AsCommand(
    name: 'app:user-importer',
    description: 'User Importer',
)]
class UserImporterCommand extends Command
{
    public function __construct(
        EntityManagerInterface $manager,
        private UserPasswordHasherInterface $passwordHasher,)
    {
        $this->manager = $manager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('path', InputArgument::OPTIONAL, 'The path of file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $path = $input->getArgument('path');

        if (($handle = fopen($path, 'r')) !== false) {

            fgetcsv($handle, 1000, ",");
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                              
                $user = 
                    (new User())
                        ->setName($data[1])
                        ->setEmail($data[2])
                        ->setPassword(
                            $this->passwordHasher->hashPassword(
                                $user,
                                $data[3]
                            ));
                               
                $this->manager->persist($user);            
            }
            $this->manager->flush();
        }
        
        $io->success('Users have been added to the database!');

        return Command::SUCCESS;
    }
}
