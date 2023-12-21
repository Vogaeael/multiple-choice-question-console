<?php

namespace unit\QuestionLoader\FileLoader;

use PHPUnit\Framework\TestCase;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileLoader\Exceptions\FileDoesNotExistException;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileLoader\Exceptions\FileIsADirectoryException;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileLoader\Exceptions\FileIsNotReadableException;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileLoader\FileContentLoader;

class FileContentLoaderTest extends TestCase
{
    protected FileContentLoader $fileContentLoader;

    protected function setUp(): void
    {
        $this->fileContentLoader = new FileContentLoader();
    }

    public function testFileDoesNotExist(): void
    {
        $this->expectException(FileDoesNotExistException::class);

        $this->fileContentLoader->load('tests/unit/QuestionLoader/FileLoader/test_files/not_existing_file');
    }

    public function testFileIsADirectory(): void
    {
        $this->expectException(FileIsADirectoryException::class);

        $this->fileContentLoader->load('tests/unit/QuestionLoader/FileLoader/test_files/not_a_file');
    }

    public function testFileIsNotReadable(): void
    {
        chmod('tests/unit/QuestionLoader/FileLoader/test_files/not_readable_file.txt', 0200);
        $this->expectException(FileIsNotReadableException::class);

        $this->fileContentLoader->load('tests/unit/QuestionLoader/FileLoader/test_files/not_readable_file.txt');
    }

    public function testGetFileContent(): void
    {
        $expected = 'This file is readable!' . PHP_EOL;
        $actual = $this->fileContentLoader->load('tests/unit/QuestionLoader/FileLoader/test_files/readable_file.txt');

        $this->assertEquals($expected, $actual);
    }
}
