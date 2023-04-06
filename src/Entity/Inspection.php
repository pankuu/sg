<?php

namespace App\Entity;

use App\Entity\Trait\CommonProperties;
use App\Repository\InspectionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InspectionRepository::class)]
#[ORM\Index(columns: ['description'], name: 'inspection_description_idx')]
class Inspection
{
    use CommonProperties;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $reviewDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $weekOfTheYear = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $maintenanceAfterReview = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReviewDate(): ?\DateTimeInterface
    {
        return $this->reviewDate;
    }

    public function setReviewDate(?\DateTimeInterface $reviewDate): self
    {
        $this->reviewDate = $reviewDate;

        return $this;
    }

    public function getWeekOfTheYear(): ?int
    {
        return $this->weekOfTheYear;
    }

    public function setWeekOfTheYear(?int $weekOfTheYear = null): self
    {
        $this->weekOfTheYear = $weekOfTheYear;

        return $this;
    }

    public function getMaintenanceAfterReview(): ?string
    {
        return $this->maintenanceAfterReview;
    }

    public function setMaintenanceAfterReview(?string $maintenanceAfterReview = null): self
    {
        $this->maintenanceAfterReview = $maintenanceAfterReview;

        return $this;
    }
}
