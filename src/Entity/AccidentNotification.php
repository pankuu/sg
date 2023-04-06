<?php

namespace App\Entity;

use App\Entity\Trait\CommonProperties;
use App\Repository\AccidentNotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccidentNotificationRepository::class)]
#[ORM\Index(columns: ['description'], name: 'accident_notification_description_idx')]
class AccidentNotification
{
    use CommonProperties;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $priority = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfVisit = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $serviceNotes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getDateOfVisit(): ?\DateTimeInterface
    {
        return $this->dateOfVisit;
    }

    public function setDateOfVisit(?\DateTimeInterface $dateOfVisit): self
    {
        $this->dateOfVisit = $dateOfVisit;

        return $this;
    }

    public function getServiceNotes(): ?string
    {
        return $this->serviceNotes;
    }

    public function setServiceNotes(?string $serviceNotes = null): self
    {
        $this->serviceNotes = $serviceNotes;

        return $this;
    }
}
