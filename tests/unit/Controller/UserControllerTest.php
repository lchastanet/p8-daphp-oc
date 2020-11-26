<?php

namespace App\Tests\unit\Controller;

use App\Entity\User;
use App\Tests\LoginUtility;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testListAction()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $client->request('GET', '/users');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/users/create');

        $token = $crawler->filter('input[name="user[_token]"]')->extract(array('value'))[0];

        $client->request('POST', "/users/create", [
            'user' => [
                'username' => 'test',
                'password' => [
                    'first' => 'test',
                    'second' => 'test',
                ],
                'email' => 'test@test.fr',
                'roles' => "ROLE_USER",
                '_token' => $token,
            ]
        ]);

        $entityManager = $client->getContainer()
            ->get('doctrine')
            ->getManager();

        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();

        $entityManager->remove(end($users));

        $entityManager->flush();

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testEditAction()
    {
        $client = static::createClient();

        $entityManager = $client->getContainer()
            ->get('doctrine')
            ->getManager();

        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();

        $user = end($users);

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/users/' . $user->getId() . '/edit');

        $token = $crawler->filter('input[name="user[_token]"]')->extract(array('value'))[0];

        $client->request('POST', '/users/' . $user->getId() . '/edit', [
            'user' => [
                'username' => $user->getUsername(),
                'password' => [
                    'first' => $user->getPassword(),
                    'second' => $user->getPassword()
                ],
                'email' => $user->getEmail(),
                'roles' => implode($user->getRoles()),
                '_token' => $token
            ]
        ]);

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }
}
