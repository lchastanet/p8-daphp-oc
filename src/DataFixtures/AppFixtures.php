<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $user = new User();

        $user->setUsername("anonymous");
        $user->setPassword($this->encoder->encodePassword($user, 'password'));
        $user->setEmail($faker->email);
        $user->setRoles(['ROLE_USER']);

        $manager->persist($user);

        for ($j = 0; $j < 10; $j++) {
            $task = new Task();

            $task->setCreatedAt(new \DateTime());
            $task->setTitle($faker->sentence(5, true));
            $task->setContent($faker->text(200));
            $task->toggle(random_int(0, 1));
            $task->setUser($user);

            $manager->persist($task);
        }

        $user = new User();

        $user->setUsername("admin");
        $user->setPassword($this->encoder->encodePassword($user, 'admin'));
        $user->setEmail($faker->email);
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $user = new User();

        $user->setUsername("userTest");
        $user->setPassword($this->encoder->encodePassword($user, 'password'));
        $user->setEmail($faker->email);
        $user->setRoles(['ROLE_USER']);

        $manager->persist($user);

        for ($j = 0; $j < 5; $j++) {
            $user = new User();

            $user->setUsername($faker->userName);
            $user->setPassword($this->encoder->encodePassword($user, 'password'));
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
