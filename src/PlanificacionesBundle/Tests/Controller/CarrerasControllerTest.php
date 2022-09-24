<?php

namespace PlanificacionesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarrerasControllerTest extends WebTestCase
{
    public function testGetasignaturas()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getAsignaturas');
    }

}
