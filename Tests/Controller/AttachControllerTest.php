<?php

namespace Hexmedia\ContentBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AttachControllerTest extends WebTestCase
{
    public function testCustomize()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/customize');
    }

    public function testAttach()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/attach');
    }

}
