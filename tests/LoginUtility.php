<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

class LoginUtility
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function login()
    {
        $entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();

        $user = $entityManager
            ->getRepository(User::class)
            ->findOneBy([
                'username' => 'admin'
            ]);

        $session = $this->client->getContainer()->get('session');

        $firewall = 'main';
        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());

        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
