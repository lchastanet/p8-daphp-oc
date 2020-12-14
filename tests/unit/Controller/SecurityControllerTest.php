<?php

namespace App\Tests\unit\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \App\Controller\SecurityController
 */
class SecurityControllerTest extends WebTestCase
{
    /**
     * test if the login page is reachable
     *
     * @return void
     */
    public function testLoginAction()
    {
        $client = static::createClient();

        $client->request('GET', "/login");

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}
