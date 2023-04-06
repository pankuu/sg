<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\HandleFile;
use App\Validator\FileValidator;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HandleFileTest extends WebTestCase
{
    private EntityManagerInterface $entityManager;
    private LoggerInterface $fileLogger;
    private FileValidator $validator;
    private string $filename;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->fileLogger = $kernel->getContainer()
            ->get('monolog.logger.file');

        $this->validator = new FileValidator();

        $this->data = '[{"number":2,"description":"Prośba o wizytę    ","dueDate":"2020-01-07 00:30:11","phone":"\""}]';
        $this->filename = dirname(__FILE__).'/example.json';
        file_put_contents($this->filename, $this->data);

        parent::setUp();
    }

    public function testHandle(): void
    {
        $handleFile = new HandleFile(
            $this->fileLogger,
            $this->validator,
            $this->entityManager,
            'reports/'
        );

        $handle = $handleFile->handle($this->filename);

        $this->assertIsArray($handle);
        $this->assertCount(4, $handle);
    }

    protected function tearDown(): void
    {
        if (true === file_exists($this->filename)) {
            unlink($this->filename);
        }

        parent::tearDown();
    }
}
