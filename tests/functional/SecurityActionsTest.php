<?php

namespace App\Tests\Functional;

use App\Tests\LoginUtility;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityActionsTest extends WebTestCase
{
    public function testLoginOk()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $loginForm = $crawler->selectButton("Se connecter")->form();

        $this->assertNotEquals(null, $loginForm);

        $loginForm['_username'] = 'admin';
        $loginForm['_password'] = 'admin';

        $crawler = $client->submit($loginForm);
        $crawler = $client->followRedirect();

        $this->assertStringContainsString('Créer une nouvelle tâche', $crawler->text(null, false));
    }

    public function testLoginKo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $loginForm = $crawler->selectButton("Se connecter")->form();

        $this->assertNotEquals(null, $loginForm);

        $loginForm['_username'] = 'admin';
        $loginForm['_password'] = 'false';

        $crawler = $client->submit($loginForm);
        $crawler = $client->followRedirect();

        $this->assertStringContainsString('Invalid credentials.', $crawler->text(null, false));
    }

    public function testLogout()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $client->request('GET', '/logout');

        $client->setMaxRedirects(2);
        $crawler = $client->followRedirect();

        $this->assertSame("Se connecter", $crawler->filter('button')->text());
    }
}
