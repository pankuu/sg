<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\InvalidFileExtensionException;

class FileValidator
{
    /**
     * @throws InvalidFileExtensionException
     */
    public function fileExtension(string $path): void
    {
        $file = pathinfo($path);

        if (isset($file['extension']) && 'json' !== $file['extension']) {
            throw new InvalidFileExtensionException();
        }
    }

    /**
     * @throws \Exception
     */
    public function hasProperStructure(\stdClass $item): void
    {
        $json = json_encode($item);

        if (!is_string($json)) {
            throw new \Exception('Cannot encode data');
        }

        $data = json_decode($json, true);

        if (!array_key_exists('number', $data)
            || !array_key_exists('description', $data)
            || !array_key_exists('dueDate', $data)
            || !array_key_exists('phone', $data)) {
            throw new \Exception('One of keys have wrong name');
        }
    }

    /**
     * @throws \Exception
     */
    public function isRegistrationReported(string $description, string $filename): bool
    {
        if (!file_exists($filename)) {
            touch($filename);
        }

        $f = fopen($filename, 'r+');

        if (!$f) {
            throw new \Exception('Resource error');
        }

        if (0 === filesize($filename)) {
            return false;
        }

        $filesize = filesize($filename);

        if (!$filesize) {
            throw new \Exception('Failed to read filesize.');
        }

        $content = fread($f, $filesize);

        if (!is_string($content)) {
            throw new \Exception('Failed to read resource.');
        }

        fclose($f);

        if (str_contains($content, $description)) {
            return true;
        }

        return false;
    }
}
