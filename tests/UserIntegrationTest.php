<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserIntegrationTest extends WebTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function userInsertion()
    {
        $client = static::createClient();

        $user = ['user' => [
            'firstname' => 'Yassine',
            'lastname' => 'Bousaidi',
            'email' => 'Yassine.bousaidi@gmail.com',
            'password' => '12345678'
        ]
        ];

        $client->request('POST', 'user/new', $user);

        $this->assertEquals(409, $client->getResponse()->getStatusCode());
    }

    public function testUserWithoutName()
    {
        $client = static::createClient();
        $user = ['user' => [
            'email' => 'Yassine.bousaidi@gmail.com',
            'password' => '12345678'
        ]
        ];
        $client->request('POST', 'user/new', $user);

        $this->assertEquals(422, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function passwordTooShort()
    {
        $client = static::createClient();
        $user = ['user' => [
            'email' => 'Yassine.bousaidi@gmail.com',
            'password' => '1234678'
        ]
        ];
        $client->request('POST', 'user/new', $user);
        $this->assertEquals(422, $client->getResponse()->getStatusCode());
    }

}
