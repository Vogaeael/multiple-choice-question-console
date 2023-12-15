<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;

use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class QuestionCollection implements QuestionCollectionInterface
{
    /** @var QuestionInterface[] $questions */
    private array $questions;

    public function __construct()
    {
        $this->questions = [];
    }

    public function add(QuestionInterface $question): void
    {
        $this->questions[] = $question;
    }

    /**
     * @throws Exception
     */
    public function getNext(): QuestionInterface
    {
        return $this->questions[random_int(0, count($this->questions) - 1)];
    }
}
