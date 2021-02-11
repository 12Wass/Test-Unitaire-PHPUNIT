<?php

namespace App\Test;

use App\Entity\User;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class UserIntegrationTest extends WebTestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $today = new DateTime('now');
        $birthday = $today->sub(new \DateInterval('P30Y'))->format('Y-m-d');

        $this->user = new User(
            'DAHMANE',
            'Wassim',
            'wassimdah@gmail.com',
            'jesuispasfandestestsunitaires',
            "$birthday"
        );
    }

    public function testPasswordTooShort()
    {
        $client = static::createClient();

        $user = [
          'firstname' => 'Yassine',
            'lastname' => 'Bousaidi',
            'email' => 'Yassine.bousaidi@gmail.com',
            'password' => '1345678'
        ];

        $client->request('POST', 'user/new', $user);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}
