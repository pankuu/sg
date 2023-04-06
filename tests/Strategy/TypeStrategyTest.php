<?php

declare(strict_types=1);

namespace App\Tests\Strategy;

use App\Service\Methods\AccidentMethod;
use App\Service\Methods\InspectionMethod;
use App\Strategy\TypeStrategy;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TypeStrategyTest extends WebTestCase
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

    public function testTypeStrategyReturnInspectionMethodInstance(): void
    {
        $description = 'Opis zawierający słowo: przegląd';

        $strategy = TypeStrategy::type($description, $this->entityManager);

        $this->assertInstanceOf(InspectionMethod::class, $strategy);
    }

    public function testTypeStrategyReturnAccidentMethodInstance(): void
    {
        $description = 'Opis który jest odpowiedni do uzyskania zdarzenia';

        $strategy = TypeStrategy::type($description, $this->entityManager);

        $this->assertInstanceOf(AccidentMethod::class, $strategy);
    }
}
