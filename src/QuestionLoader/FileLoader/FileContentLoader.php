<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileLoader;

use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileLoader\Exceptions\FileDoesNotExistException;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileLoader\Exceptions\FileIsADirectoryException;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileLoader\Exceptions\FileIsNotReadableException;

class FileContentLoader
{
    /**
     * @throws Exception
     */
    public function load(string $path): string
    {
        $this->validateFileExistAndReadable($path);

        return file_get_contents($path);
    }

    /**
     * @throws Exception
     */
    protected function validateFileExistAndReadable(string $path): void
    {
        if (!file_exists($path)) {
            throw new FileDoesNotExistException(sprintf('File `%s` does not exist', $path));
        }
        if (!is_file($path)) {
            throw new FileIsADirectoryException(sprintf('`%s` is not a file', $path));
        }
        if (!is_readable($path)) {
            throw new FileIsNotReadableException(sprintf('File `%s` is not readable', $path));
        }
    }
}
