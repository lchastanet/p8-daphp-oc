<?php

namespace App\Tests\Functional;

use App\Tests\LoginUtility;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \App\Controller\DefaultController
 */
class DefaultActionsTest extends WebTestCase
{
    /**
     * test redirection when trying to get home when unauthenticated
     *
     * @return void
     */
    public function testIndexActionUnauthenticated()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        $this->assertSame("Se connecter", $crawler->filter('button')->text());
    }

    /**
     * test homepage when authenticated
     *
     * @return void
     */
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
