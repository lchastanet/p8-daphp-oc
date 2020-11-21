<?php

namespace App\Tests\Controller;

use App\Tests\LoginUtility;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testListAction()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks');

        $this->assertSame(302, $client->getResponse()->getStatusCode());

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/tasks');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertStringContainsString('Créer un utilisateur', $crawler->text(null, true));
    }

    public function testCreateAction()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks/create');

        $this->assertSame(302, $client->getResponse()->getStatusCode());

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/tasks/create');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $title = 'Un titre';
        $content = 'Un super contenu!';
        $token = $crawler->filter('input[name="task[_token]"]')->extract(array('value'))[0];

        $client->request('POST', "/tasks/create", [
            'task' => [
                'title' => $title,
                'content' => $content,
                '_token' => $token
            ]
        ]);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        $this->assertSame($title, $crawler->filter('h4 a')->last()->text());
        $this->assertSame($content, $crawler->filter('.caption p')->last()->text());
    }

    public function testEditAction()
    {
    }
}
