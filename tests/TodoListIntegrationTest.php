<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TodoListIntegrationTest extends WebTestCase
{

    protected function setUp(): void
    {

        parent::setUp();
    }

    /**
     * @test
     */
    public
    function CreateTodoListWithoutUser()
    {

        $todoList = ['todo_list' => [
            'name' => 'Ma super Todo à un user qui en a deja une',
            'description' => 'lorem ipsum dolor sit amet',
        ]
        ];
        $client = static::createClient();

        $client->request('POST', 'todo/list/new', $todoList);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

}
