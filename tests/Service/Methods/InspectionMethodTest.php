<?php

declare(strict_types=1);

namespace App\Tests\Service\Methods;

use App\DTO\DTOInterface;
use App\Service\Methods\InspectionMethod;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InspectionMethodTest extends WebTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        parent::setUp();
    }

    public function testHandle(): void
    {
        $accidentMethod = new InspectionMethod($this->entityManager);

        $object = new \stdClass();
        $object->number = 1;
        $object->description = 'description';
        $object->dueDate = '';
        $object->phone = null;

        $handle = $accidentMethod->handle($object);

        $this->assertInstanceOf(DTOInterface::class, $handle);
    }
}
