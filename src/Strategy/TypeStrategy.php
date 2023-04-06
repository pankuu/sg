<?php

declare(strict_types=1);

namespace App\Strategy;

use App\Service\Methods\AccidentMethod;
use App\Service\Methods\HandleMethodInterface;
use App\Service\Methods\InspectionMethod;
use Doctrine\ORM\EntityManagerInterface;

class TypeStrategy
{
    public static function type(string $description, EntityManagerInterface $entityManager): HandleMethodInterface
    {
        if (str_contains($description, 'przegląd')) {
            return new InspectionMethod($entityManager);
        }

        return new AccidentMethod($entityManager);
    }
}
