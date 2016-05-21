<?php

namespace Tools;

require_once(__DIR__.'/../../app/AppKernel.php');

use AppKernel;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\DependencyInjection\Container;

abstract class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    use DataBuilder, HttpTestClient;
    /**
     * @var AppKernel
     */
    protected $kernel;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var Container
     */
    protected $container;
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    protected $client;

    public function __construct()
    {
        $kernel = new \AppKernel("test", true);
        $kernel->boot();
        $this->container = $kernel->getContainer();
        parent::__construct();
        $this->client = $kernel->getContainer()->get('test.client');
    }

    protected function mockService($service, $class, array $methodsAndResult)
    {
        $mock = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();

        foreach ($methodsAndResult as $method => $result) {
            $mock
                ->expects($this->atLeast(0))
                ->method($method)
                ->will($this->returnValue($result));
        }

        $this->container->set($service, $mock);
    }

    protected function mockServiceWillReturnCallback($service, $class, array $methodsAndResult)
    {
        $mock = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();

        foreach ($methodsAndResult as $method => $result) {
            $mock
                ->expects($this->atLeast(0))
                ->method($method)
                ->will($this->returnCallback($result));
        }

        $this->container->set($service, $mock);
    }

    public function setUp()
    {
        // Boot the AppKernel in the test environment and with the debug.
        $this->kernel = new AppKernel('test', true);
        $this->kernel->boot();

        // Store the container and the entity manager in test case properties
        $this->container = $this->kernel->getContainer();
        $this->entityManager = $this->container->get('doctrine.orm.default_entity_manager');

        // Build the schema for sqlite
        $this->generateSchema();

        parent::setUp();
        $this->bootstrap($this->entityManager);
    }

    public function tearDown()
    {
        $this->dropSchema();
        // Shutdown the kernel.
        $this->kernel->shutdown();
        unlink($this->container->getParameter('kernel.cache_dir').'/data.sqlite');

        parent::tearDown();
    }

    protected function dropSchema()
    {
        // Get the metadata of the application to create the schema.
        $metadata = $this->getMetadata();

        if ( ! empty($metadata)) {
            // Create SchemaTool
            $tool = new SchemaTool($this->entityManager);
            $tool->dropSchema($metadata);
        } else {
            throw new SchemaException('No Metadata Classes to process.');
        }
    }

    protected function generateSchema()
    {
        // Get the metadata of the application to create the schema.
        $metadata = $this->getMetadata();

        if ( ! empty($metadata)) {
            // Create SchemaTool
            $tool = new SchemaTool($this->entityManager);
            $tool->createSchema($metadata);
        } else {
            throw new SchemaException('No Metadata Classes to process.');
        }
    }

    /**
     * Overwrite this method to get specific metadata.
     *
     * @return array
     */
    protected function getMetadata()
    {
        $res= array();
        $res[] = $this->entityManager->getMetadataFactory()->getMetadataFor('AppBundle:MailConfig');
        $res[] = $this->entityManager->getMetadataFactory()->getMetadataFor('AppBundle:User');

        return $res;
    }
}
