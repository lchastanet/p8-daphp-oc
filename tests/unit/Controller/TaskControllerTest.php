<?php

namespace App\Tests\unit\Controller;

use App\Entity\Task;
use App\Tests\LoginUtility;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \App\Controller\TaskController
 * @covers \App\Entity\Task
 */
class TaskControllerTest extends WebTestCase
{
    /**
     * test if the tasks list page is reachable
     *
     * @return void
     */
    public function testListAction()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $client->request('GET', '/tasks');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    /**
     * test if a task can be created
     *
     * @return void
     */
    public function testCreateAction()
    {
        $client = static::createClient();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $crawler = $client->request('GET', '/tasks/create');

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

        $crawler = $client->followRedirect();

        $this->assertSame($title, $crawler->filter('h4 a')->last()->text());
    }

    /**
     * test if a task can be edited
     *
     * @return void
     */
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

        $token = $crawler->filter('input[name="task[_token]"]')->extract(array('value'))[0];

        $client->request('POST', '/tasks/' . $task->getId() . '/edit', [
            'task' => [
                'title' => $task->getTitle(),
                'content' => $task->getContent(),
                '_token' => $token
            ]
        ]);

        $crawler = $client->followRedirect();

        $this->assertSame($task->getTitle(), $crawler->filter('h4 a')->last()->text());
    }

    /**
     * test if a task can be set to done or not
     *
     * @return void
     */
    public function testToggleTaskAction()
    {
        $client = static::createClient();

        $entityManager = $client->getContainer()
            ->get('doctrine')
            ->getManager();

        $tasks = $entityManager
            ->getRepository(Task::class)
            ->findAll();

        $task = end($tasks);

        $taskNotModified = $task->isDone();

        $loginUtility = new LoginUtility($client);

        $loginUtility->login();

        $client->request('GET', '/tasks/' . $task->getId() . '/toggle');

        $taskModified = $task->isDone();

        $this->assertNotEquals($taskNotModified, $taskModified);
    }

    /**
     * test if a task can be deleted
     *
     * @return void
     */
    public function testDeleteTaskAction()
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

        $client->request('GET', '/tasks/' . $task->getId() . '/delete');

        $tasks = $entityManager
            ->getRepository(Task::class)
            ->findAll();

        $newLastTask = end($tasks);

        $this->assertNotEquals($newLastTask, $task);
    }
}
