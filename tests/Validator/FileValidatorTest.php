<?php

declare(strict_types=1);

namespace App\Tests\Validator;

use App\Exception\InvalidFileExtensionException;
use App\Validator\FileValidator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FileValidatorTest extends WebTestCase
{
    private FileValidator $fileValidator;
    private string $filenameWrongExtension;
    private string $filename;

    protected function setUp(): void
    {
        $data = '[{"number":2,"description":"Prośba o wizytę    ","dueDate":"2020-01-07 00:30:11","phone":"\""}]';
        $this->filenameWrongExtension = dirname(__FILE__).'/example.txt';
        $this->filename = dirname(__FILE__).'/example.json';
        $this->fileValidator = new FileValidator();

        $this->createFile($this->filenameWrongExtension, '');
        $this->createFile(
            $this->filename,
            $data
        );

        parent::setUp();
    }

    public function testFileExtensionThrownError(): void
    {
        $this->expectException(InvalidFileExtensionException::class);

        $this->fileValidator->fileExtension($this->filenameWrongExtension);
    }

    public function testFileHasNotProperStructure(): void
    {
        $object = new \stdClass();
        $object->number = 1;
        $object->descriptions = 'description';
        $object->dueDate = '';
        $object->phone = null;

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('One of keys have wrong name');

        $this->fileValidator->hasProperStructure($object);
    }

    /**
     * @throws \Exception
     */
    public function testIsRegistrationReported(): void
    {
        $isRegistrationReported = $this->fileValidator->isRegistrationReported('Prośba o wizytę    ', $this->filename);

        $this->assertTrue($isRegistrationReported);
    }

    /**
     * @throws \Exception
     */
    public function testIsRegistrationNotReported(): void
    {
        $isRegistrationReported = $this->fileValidator->isRegistrationReported('Tstowa wiadomość', $this->filename);

        $this->assertFalse($isRegistrationReported);
    }

    public function tearDown(): void
    {
        $this->deleteFile($this->filename);
        $this->deleteFile($this->filenameWrongExtension);
    }

    private function createFile(string $filename, string $data): void
    {
        file_put_contents($filename, $data);
    }

    private function deleteFile(string $filename): void
    {
        if (true === file_exists($filename)) {
            unlink($filename);
        }
    }
}
