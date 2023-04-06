<?php

declare(strict_types=1);

namespace App\DTO;

class AccidentDTO implements DTOInterface
{
    public function __construct(
        public readonly ?string $dateOfVisit,
        public readonly string $status,
        public readonly string $type,
        public readonly string $description,
        public readonly string $priority,
        public readonly ?string $phoneNumber,
        public readonly string $createdAt,
    ) {
    }
}
