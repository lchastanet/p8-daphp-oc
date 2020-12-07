<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\LoginUtility;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserActionsTest extends WebTestCase
{
    public function testListAction()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login('userTest');

        $crawler = $client->request('GET', '/users');

        $this->assertStringContainsString('Access Denied.', $crawler->text(null, true));

        $loginUtility->login();

        $crawler = $client->request('GET', '/users');

        $this->assertStringContainsString('Liste des utilisateurs', $crawler->text(null, true));
    }

    public function testCreateAction()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/users/create');

        $createUserForm = $crawler->selectButton("Ajouter")->form();
        $userName = "userNameTest";
        $password = "password";
        $email = "hello@mail.com";
        $roles = "ROLE_USER";

        $createUserForm['user[username]'] = $userName;
        $createUserForm['user[password][first]'] = $password;
        $createUserForm['user[password][second]'] = $password;
        $createUserForm['user[email]'] = $email;
        $createUserForm['user[roles]'] = $roles;

        $crawler = $client->submit($createUserForm);

        $crawler = $client->followRedirect();

        $this->assertStringContainsString('L\'utilisateur a bien été ajouté.', $crawler->filter('div.alert.alert-success')->text(null, false));
        $this->assertStringContainsString($userName, $crawler->text(null, true));
        $this->assertStringContainsString($email, $crawler->text(null, true));
    }

    public function testEditAction()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/users');

        $uri = $crawler->filter(".btn-success")->last()->link()->getUri();

        $crawler = $client->request('GET', $uri);

        $editUserForm = $crawler->selectButton("Modifier")->form();

        $editUserForm['user[username]'] = "userTestModified";
        $editUserForm['user[password][first]'] = "password";
        $editUserForm['user[password][second]'] = "password";

        $crawler = $client->submit($editUserForm);

        $crawler = $client->followRedirect();

        $this->assertStringContainsString('L\'utilisateur a bien été modifié', $crawler->filter('div.alert.alert-success')->text(null, false));

        //delete user created for Tests

        $entityManager = $client->getContainer()
            ->get('doctrine')
            ->getManager();

        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();

        $user = end($users);

        $entityManager->remove($user);
        $entityManager->flush();
    }
}
