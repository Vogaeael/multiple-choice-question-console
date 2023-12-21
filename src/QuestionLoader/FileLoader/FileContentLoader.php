<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileLoader;

use Exception;

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
            throw new Exception(sprintf('File `%s` does not exist', $path));
        }
        if (!is_file($path)) {
            throw new Exception(sprintf('`%s` is not a file', $path));
        }
        if (!is_readable($path)) {
            throw new Exception(sprintf('File `%s` is not readable', $path));
        }
    }
}
