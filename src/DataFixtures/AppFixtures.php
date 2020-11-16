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

        for ($i = 0; $i < 5; $i++) {
            $user = new User();

            $user->setUsername($faker->unique()->userName);
            $user->setPassword($this->encoder->encodePassword($user, 'password'));
            $user->setEmail($faker->email);

            $limit = random_int(1, 3);

            for ($j = 0; $j < $limit; $j++) {
                $task = new Task();

                $task->setCreatedAt(new \DateTime());
                $task->setTitle($faker->sentence(5, true));
                $task->setContent($faker->text(200));
                $task->toggle(random_int(0, 1));

                $manager->persist($task);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
