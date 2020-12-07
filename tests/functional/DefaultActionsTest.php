<?php

namespace App\Tests\Functional;

use App\Tests\LoginUtility;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultActionsTest extends WebTestCase
{
    public function testIndexActionUnauthenticated()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        $this->assertSame("Se connecter", $crawler->filter('button')->text());
    }

    public function testIndexActionAuthenticated()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertStringContainsString("Se déconnecter", $crawler->text(null, false));
    }
}
