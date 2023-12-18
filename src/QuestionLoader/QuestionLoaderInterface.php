<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionInterface;

interface QuestionLoaderInterface
{
    /**
     * Load the Question from a file
     */
    public function load(string $path, string $type): QuestionCollectionInterface;
}
