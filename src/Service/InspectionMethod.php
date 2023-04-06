<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\DTOInterface;
use App\DTO\InspectionDTO;
use App\Entity\Inspection;
use App\Enum\MethodType;
use App\Enum\Status;

class InspectionMethod extends AbstractTypeMethod
{
    public function handle(\stdClass $item): DTOInterface
    {
        $dto = new InspectionDTO(
            $item->description,
            MethodType::INSPECTION->value,
            $item->dueDate ? Status::SCHEDULED->value : Status::NEW->value,
            $item->dueDate ? (int) date('W', strtotime($item->dueDate)) : null,
            $item->dueDate ? date('d-m-Y', strtotime($item->dueDate)) : null,
            $item->phone,
            date('d-m-Y H:i')
        );

        $this->object = $dto;

        return $dto;
    }

    public function saveToDB(DTOInterface $dto): void
    {
        if ($this->isNotificationExists(Inspection::class, $dto->description)) {
            return;
        }

        $inspection = new Inspection();
        $inspection->setType($dto->type);
        $inspection->setReviewDate($dto->reviewDate ? new \DateTime($dto->reviewDate) : null);
        $inspection->setWeekOfTheYear($dto->weekOfTheYear);
        $inspection->setDescription($dto->description);
        $inspection->setStatus($dto->status);
        $inspection->setPhoneNumber($dto->phoneNumber);
        $inspection->setCreatedAt(new \DateTime($dto->createdAt));

        $this->insert($inspection);
    }
}
