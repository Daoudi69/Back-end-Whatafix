<?php

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ApiHeroControllerTest extends WebTestCase
{
    /**
     * 
     */
    public function setUp() {
        self::bootKernel();
        //On peut également récupérer l'ObjectManager comme ça, après avoir
        //lancé la méthode bootKernel()
        $manager = self::$container->get('doctrine.orm.entity_manager');
        //L'ORMPurger va nous permettre de vider la bdd avant de relancer la fixture
        $purger = new ORMPurger($manager);
        $purger->purge();
        $manager->getConnection()->exec("ALTER TABLE hero AUTO_INCREMENT = 1;");
        $fixtures = new AppFixtures();
        $fixtures->load($manager);
    }

    public function testGetAll()
    {
        $client = static::createClient();
        $client->request('GET', '/api/hero');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();

        $this->assertCount(5, $data);
        $this->assertTrue(is_int($data[0]['level']));
        
    }

    public function testGetOne()
    {
        $client = static::createClient();
        $client->request('GET', '/api/hero/1');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();

        $this->assertTrue(is_int($data['level']));
        
    }

    public function testAddHero() {
        $client = static::createClient();

        $json = json_encode([
            'name' => 'test', 
            'title' => 'title test',
            'birthdate' => '2001-01-01', 
            'level' => 10
        ]);

        $client->request('POST', '/api/hero', [], [], [], $json);

        $this->assertResponseStatusCodeSame(201);
    }
}
