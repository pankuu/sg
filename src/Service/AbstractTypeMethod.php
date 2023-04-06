<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractTypeMethod implements HandleMethodInterface
{
    protected object $object;

    public function __construct(protected readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws \Exception
     */
    public function saveToFile(string $filename): void
    {
        if (file_exists($filename)) {
            $json = file_get_contents($filename);
            if (!is_string($json)) {
                throw new \Exception('Cannot get content from a file.');
            }

            $data = json_decode($json);
        }

        $data[] = $this->object;

        file_put_contents(
            $filename,
            json_encode($data, JSON_UNESCAPED_UNICODE)
        );

        unset($this->object);
    }

    protected function insert(object $object): void
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }

    protected function isNotificationExists(string $class, string $description): bool
    {
        return null === empty($this->entityManager->getRepository($class)->findOneBy(['description' => $description]));
    }
}
