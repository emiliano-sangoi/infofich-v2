<?php

namespace PlanificacionesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlanificacionControllerTest extends WebTestCase
{
    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/nueva');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editar');
    }

}
