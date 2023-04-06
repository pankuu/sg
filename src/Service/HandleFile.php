<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\MethodType;
use App\Exception\DescriptionRepeatedException;
use App\Exception\InvalidFileExtensionException;
use App\Service\Methods\HandleMethodInterface;
use App\Strategy\TypeStrategy;
use App\Validator\FileValidator;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class HandleFile
{
    private int $review = 0;
    private int $accident = 0;
    private int $failed = 0;

    /**
     * @var array<int, array<int|string, string>|string>
     */
    private array $failedNumber = [];

    public function __construct(
        private readonly LoggerInterface $fileLogger,
        private readonly FileValidator $validator,
        private readonly EntityManagerInterface $entityManager,
        private readonly string $pathReport
    ) {
    }

    /**
     * @return array<int, array<int, array<int|string, string>|string>|int>
     *
     * @throws InvalidFileExtensionException
     * @throws \Exception
     */
    public function handle(string $path): array
    {
        $this->validator->fileExtension($path);

        $content = $this->getContent($path);

        if (!is_string($content)) {
            throw new \Exception('Cannot get content from a file.');
        }

        $data = json_decode($content);

        foreach ($data as $item) {
            try {
                $handleMethod = TypeStrategy::type($item->description, $this->entityManager);

                $this->process($handleMethod, $item);
            } catch (\Exception $e) {
                ++$this->failed;

                file_put_contents(
                    sprintf('%sfailed.json', $this->pathReport),
                    json_encode($item, JSON_UNESCAPED_UNICODE),
                    FILE_APPEND
                );

                $this->failedNumber[] = [$item->number => $e->getMessage()];

                $this->fileLogger->error($e->getMessage());
                $this->fileLogger->error(json_encode($item, JSON_UNESCAPED_UNICODE));
            }
        }

        return [
            $this->review,
            $this->accident,
            $this->failed,
            $this->failedNumber,
        ];
    }

    /**
     * @throws DescriptionRepeatedException
     * @throws \Exception
     */
    private function process(HandleMethodInterface $handleMethod, \stdClass $item): void
    {
        $this->validator->hasProperStructure($item);

        $handle = $handleMethod->handle($item);

        $filename = sprintf('%s%s.json',
            $this->pathReport,
            str_replace(' ', '_', $handle->type)
        );

        if ($this->validator->isRegistrationReported($handle->description, $filename)) {
            throw new DescriptionRepeatedException('Notification exists.');
        }

        $this->countReports($handle->type);

        $handleMethod->saveToFile($filename);
        $handleMethod->saveToDB($handle);

        $this->fileLogger->notice(json_encode($item, JSON_UNESCAPED_UNICODE));
    }

    private function getContent(string $path): bool|string
    {
        return file_get_contents($path);
    }

    private function countReports(string $type): void
    {
        match ($type) {
            MethodType::ACCIDENT_NOTIFICATION->value => ++$this->accident,
            MethodType::INSPECTION->value => ++$this->review,
            default => 'Unrecognized type'
        };
    }
}
