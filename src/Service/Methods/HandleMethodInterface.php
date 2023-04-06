<?php

declare(strict_types=1);

namespace App\Service\Methods;

use App\DTO\DTOInterface;

interface HandleMethodInterface
{
    public function handle(\stdClass $item): DTOInterface;

    public function saveToFile(string $filename): void;

    public function saveToDB(DTOInterface $dto): void;
}
