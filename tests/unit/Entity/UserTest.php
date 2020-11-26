<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testId()
    {
        $user = new User();
        $id = null;

        $this->assertEquals($id, $user->getId());
    }

    public function testUsername()
    {
        $user = new User();
        $username = "Test username";

        $user->setUsername($username);
        $this->assertEquals($username, $user->getUsername());
    }

    public function testPassword()
    {
        $user = new User();
        $password = "test password";
        $user->setPassword($password);
        $this->assertEquals($password, $user->getPassword());
    }

    public function testEmail()
    {
        $user = new User();
        $email = "root@root.fr";

        $user->setEmail($email);
        $this->assertEquals($email, $user->getEmail());
    }

    public function testAddTask()
    {
        $user = new User();
        $task = new Task();

        $user->addTask($task);
        $this->assertEquals($task, $user->getTasks()[0]);
    }

    public function testRemoveTask()
    {
        $user = new User();
        $task = new Task();

        $user->addTask($task);
        $this->assertEquals($task, $user->getTasks()[0]);

        $user->removeTask($task);
        $this->assertEquals([], $user->getTasks()->toArray());
    }

    public function testRole()
    {
        $user = new User();
        $roles = ["ROLE_ADMIN"];

        $user->setRoles($roles);
        $this->assertEquals($roles, $user->getRoles());
    }
}
