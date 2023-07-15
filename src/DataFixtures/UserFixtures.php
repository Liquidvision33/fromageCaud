<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;


    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $dateOfBirth = new DateTime('1988-04-12');
        $admin = new User();
        $admin->setEmail('remy@fmcauderan.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordHasher->hashPassword(
                $admin,
                'password'
            ))
            ->setFirstname('Belperron')
            ->setLastname('Remy')
            ->setDateOfBirth($dateOfBirth);
        $manager->persist($admin);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                'password'
            ));
            $user->setRoles(['ROLE_USER']);
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setDateOfBirth(DateTimeImmutable::createFromMutable($faker
                ->dateTimeBetween('-50 years', '-18 years')));
            $manager->persist($user);
        }

        $manager->flush();
    }
}