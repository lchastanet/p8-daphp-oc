<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Tests\LoginUtility;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskActionsTest extends WebTestCase
{
    public function testListActionAsAdmin()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/tasks');

        $this->assertStringContainsString('Créer une tâche', $crawler->text(null, true));

        $this->assertStringContainsString('Créer un utilisateur', $crawler->text(null, true));
    }

    public function testListActionAsUser()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login('anonymous');

        $crawler = $client->request('GET', '/tasks');

        $this->assertStringContainsString('Créer une tâche', $crawler->text(null, true));

        $this->assertNotEquals('Créer un utilisateur', $crawler->text(null, true));
    }

    public function testDoneListAction()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/tasks?isDone=true');

        $this->assertStringContainsString('Créer une tâche', $crawler->text(null, true));

        $this->assertStringContainsString('Créer un utilisateur', $crawler->text(null, true));
    }


    public function testCreateAction()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/tasks/create');

        $createTaskForm = $crawler->selectButton("Ajouter")->form();
        $titleTest = 'Un titre';
        $contentTest = 'Un contenu intéressant';

        $createTaskForm['task[title]'] = $titleTest;
        $createTaskForm['task[content]'] = $contentTest;

        $crawler = $client->submit($createTaskForm);

        $crawler = $client->followRedirect();

        $this->assertStringContainsString('La tâche a été bien été ajoutée.', $crawler->filter('div.alert.alert-success')->text(null, false));
        $this->assertSame($titleTest, $crawler->filter('h4 a')->last()->text(null, false));
        $this->assertSame($contentTest, $crawler->filter('.caption p')->last()->text(null, false));
    }

    public function testEditAction()
    {
        $client = static::createClient();

        $entityManager = $client->getContainer()
            ->get('doctrine')
            ->getManager();

        $tasks = $entityManager
            ->getRepository(Task::class)
            ->findAll();

        $task = end($tasks);

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/tasks/' . $task->getId() . '/edit');

        $createTaskForm = $crawler->selectButton("Modifier")->form();
        $titleTest = $createTaskForm['task[title]']->getValue();
        $contentTest = $createTaskForm['task[content]']->getValue();

        $crawler = $client->submit($createTaskForm);

        $crawler = $client->followRedirect();

        $this->assertStringContainsString('La tâche a bien été modifiée.', $crawler->filter('div.alert.alert-success')->text(null, false));
        $this->assertSame($titleTest, $crawler->filter('h4 a')->last()->text());
        $this->assertSame($contentTest, $crawler->filter('.caption p')->last()->text());
    }

    public function testToggleAction()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/tasks');

        $createTaskForm = $crawler->selectButton("Marquer comme faite")->last()->form();

        $crawler = $client->submit($createTaskForm);

        $crawler = $client->followRedirect();

        $this->assertStringContainsString('La tâche Un titre a bien été marquée comme faite.', $crawler->filter('div.alert.alert-success')->text(null, false));
    }

    public function testDeleteAction()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login('userTest');

        $crawler = $client->request('GET', '/tasks');

        $createTaskForm = $crawler->selectButton("Supprimer")->last()->form();

        $crawler = $client->submit($createTaskForm);

        $crawler = $client->followRedirect();

        $this->assertStringContainsString('Vous n\'avez pas la permission d\'effectuer cette action.', $crawler->filter('div.alert.alert-danger')->text(null, false));

        $loginUtility->login();

        $createTaskForm = $crawler->selectButton("Supprimer")->last()->form();

        $crawler = $client->submit($createTaskForm);

        $crawler = $client->followRedirect();

        $this->assertStringContainsString('La tâche a bien été supprimée.', $crawler->filter('div.alert.alert-success')->text(null, false));
    }
}
