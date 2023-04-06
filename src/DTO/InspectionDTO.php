<?php

declare(strict_types=1);

namespace App\DTO;

/**
 * @property string $description
 * @property string $type
 * @property string $status
 */
class InspectionDTO implements DTOInterface
{
    public function __construct(
        public readonly string $description,
        public readonly string $type,
        public readonly string $status,
        public readonly ?int $weekOfTheYear,
        public readonly ?string $reviewDate,
        public readonly ?string $phoneNumber,
        public readonly string $createdAt,
    ) {
    }
}
