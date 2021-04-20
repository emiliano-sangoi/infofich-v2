<?php

namespace PlanificacionesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlanificacionAjaxControllerTest extends WebTestCase
{
    public function testGetformequipodocente()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/equipo-docente');
    }

    public function testGetinfobasicaform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/informacion-basica');
    }

    public function testGetrequisitosaprobform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/aprobacion');
    }

    public function testGetobjetivosform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/objetivos');
    }

    public function testGettemarioform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/temario');
    }

    public function testGetbibliografiaform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/bibliografia');
    }

    public function testGetcronogramaform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/cronograma');
    }

    public function testGetcargahorariaform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/carga-horaria');
    }

    public function testGetviajesacademicosform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/viajes-academicos');
    }

    public function testGetresultadosform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/resultados-asignatura');
    }

}
