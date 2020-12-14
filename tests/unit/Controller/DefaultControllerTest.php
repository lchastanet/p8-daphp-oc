<?php

namespace App\Tests\unit\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \App\Controller\DefaultController
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * test if the homepage make redirect to the login page when not logged in
     *
     * @return void
     */
    public function testIndexAction()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
