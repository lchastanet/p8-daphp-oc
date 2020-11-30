<?php

namespace App\Tests\unit\Controller;

use App\Tests\LoginUtility;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginAction()
    {
        $client = static::createClient();

        $client->request('GET', "/login");

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    // public function testLoginCheck()
    // {
    //     $client = static::createClient();

    //     $client->request('POST', "/login_check", ['_username' => 'admin', '_password' => 'admin']);

    //     $this->assertSame(302, $client->getResponse()->getStatusCode());
    // }

    // public function testLogoutCheck()
    // {
    //     $client = static::createClient();

    //     $loginUtility = new LoginUtility($client);

    //     $loginUtility->login();

    //     $client->request('GET', "/logout");

    //     $this->assertSame(302, $client->getResponse()->getStatusCode());
    // }
}
