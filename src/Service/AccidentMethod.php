<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\AccidentDTO;
use App\DTO\DTOInterface;
use App\Entity\AccidentNotification;
use App\Enum\AccidentNotification as AccidentNotificationEnum;
use App\Enum\MethodType;
use App\Enum\Priority;
use Symfony\Component\Yaml\Yaml;

class AccidentMethod extends AbstractTypeMethod
{
    public function handle(\stdClass $item): DTOInterface
    {
        $dto = new AccidentDTO(
            $item->dueDate ? date('d-m-Y', strtotime($item->dueDate)) : null,
            $item->dueDate ? AccidentNotificationEnum::DEADLINE->value : AccidentNotificationEnum::NEW->value,
            MethodType::ACCIDENT_NOTIFICATION->value,
            $item->description,
            $this->getPriority($item->description),
            $item->phone,
            date('d-m-Y H:i')
        );

        $this->object = $dto;

        return $dto;
    }

    public function saveToDB(DTOInterface $dto): void
    {
        if ($this->isNotificationExists(AccidentNotification::class, $dto->description)) {
            return;
        }

        $accident = new AccidentNotification();
        $accident->setPriority($dto->priority);
        $accident->setDateOfVisit($dto->dateOfVisit ? new \DateTime($dto->dateOfVisit) : null);
        $accident->setDescription($dto->description);
        $accident->setStatus($dto->status);
        $accident->setType($dto->type);
        $accident->setPhoneNumber($dto->phoneNumber);
        $accident->setCreatedAt(new \DateTime($dto->createdAt));

        $this->insert($accident);
    }

    private function getPriority(string $description): string
    {
        $importantDict = $this->getDictionaryFromYamlFile('important');
        $veryImportantDict = $this->getDictionaryFromYamlFile('very_important');

        $importantPattern = '('.implode('|', $importantDict).')';

        $veryImportantPattern = '('.implode('|', $veryImportantDict).')';

        if ($this->isStringContains($veryImportantPattern, $description, 1)) {
            return Priority::CRITICAL->value;
        } elseif ($this->isStringContains($importantPattern, $description, 1) && $this->isStringContains($veryImportantPattern, $description, 0)) {
            return Priority::HIGH->value;
        } else {
            return Priority::NORMAL->value;
        }
    }

    private function isStringContains(string $pattern, string $description, int $value): bool
    {
        return preg_match($pattern, strtolower($description)) === $value;
    }

    /**
     * @return array<string>
     */
    private function getDictionaryFromYamlFile(string $filename): array
    {
        return Yaml::parseFile(dirname(__DIR__, 2)."/config/dictionary/{$filename}.yaml");
    }
}
