<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \App\Entity\User
 */
class UserTest extends WebTestCase
{
    /**
     * test id of a user
     *
     * @return void
     */
    public function testId()
    {
        $user = new User();
        $idTest = null;

        $this->assertEquals($idTest, $user->getId());
    }

    /**
     * test username of a user
     *
     * @return void
     */
    public function testUsername()
    {
        $user = new User();
        $username = "Test username";

        $user->setUsername($username);
        $this->assertEquals($username, $user->getUsername());
    }

    /**
     * test password of a user
     *
     * @return void
     */
    public function testPassword()
    {
        $user = new User();
        $password = "test password";
        $user->setPassword($password);
        $this->assertEquals($password, $user->getPassword());
    }

    /**
     * test email of a user
     *
     * @return void
     */
    public function testEmail()
    {
        $user = new User();
        $email = "root@root.fr";

        $user->setEmail($email);
        $this->assertEquals($email, $user->getEmail());
    }

    /**
     * test if a task can be added to a user
     *
     * @return void
     */
    public function testAddTask()
    {
        $user = new User();
        $task = new Task();

        $user->addTask($task);
        $this->assertEquals($task, $user->getTasks()[0]);
    }

    /**
     * test if a task can be remove from a user
     *
     * @return void
     */
    public function testRemoveTask()
    {
        $user = new User();
        $task = new Task();

        $user->addTask($task);
        $this->assertEquals($task, $user->getTasks()[0]);

        $user->removeTask($task);
        $this->assertEquals([], $user->getTasks()->toArray());
    }

    /**
     * test role of a user
     *
     * @return void
     */
    public function testRole()
    {
        $user = new User();
        $roles = ["ROLE_ADMIN"];

        $user->setRoles($roles);
        $this->assertEquals($roles, $user->getRoles());
    }
}
