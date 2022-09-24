<?php

namespace PlanificacionesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AsignaturasControllerTest extends WebTestCase
{
    public function testGetinfo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/info');
    }

}
