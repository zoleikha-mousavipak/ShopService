<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
            ) {
            }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail("test@test.com");
        $user1->setPassword(
            $this->passwordHasher->hashPassword(
                $user1,
                "12345678"
            ));

        $manager->persist($user1);

        $manager->flush();
    }
}
