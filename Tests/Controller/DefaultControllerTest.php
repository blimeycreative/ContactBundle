<?php

namespace Oxygen\ContactBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase {

  public function testShow() {
    $client = static::createClient();

    $crawler = $client->request('GET', '/contact/show/1/Test');

    $this->assertTrue($crawler->filter('html:contains("Test")')->count() > 0);
  }

}
