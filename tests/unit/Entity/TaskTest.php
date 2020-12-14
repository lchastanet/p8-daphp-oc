<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Task
 */
class TaskTest extends TestCase
{
    /**
     * test id of a task
     *
     * @return void
     */
    public function testId()
    {
        $task = new Task();
        $idTest = null;

        $this->assertEquals($idTest, $task->getId());
    }

    /**
     * test creation date of a task
     *
     * @return void
     */
    public function testCreatedAt()
    {
        $task = new Task();
        $date = new \DateTime();

        $task->setCreatedAt($date);
        $this->assertEquals($date, $task->getCreatedAt());
    }

    /**
     * test title of a task
     *
     * @return void
     */
    public function testTitle()
    {
        $task = new Task();
        $title = "title";

        $task->setTitle($title);
        $this->assertEquals($title, $task->getTitle());
    }

    /**
     * test content of a task
     *
     * @return void
     */
    public function testContent()
    {
        $task = new Task();
        $content = "content";

        $task->setContent($content);
        $this->assertEquals($content, $task->getContent());
    }

    /**
     * test boolean status of a task
     *
     * @return void
     */
    public function testIsDone()
    {
        $task = new Task();
        $isDone = true;

        $task->toggle($isDone);
        $this->assertEquals($isDone, $task->isDone());
    }

    /**
     * test user of a task
     *
     * @return void
     */
    public function testUser()
    {
        $task = new Task();
        $user = new User();

        $task->setUser($user);
        $this->assertEquals($user, $task->getUser());
    }
}
