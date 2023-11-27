<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions;

use Exception;

class QuestionCollection
{
    /** @var Question[] $questions */
    private array $questions;

    public function __construct()
    {
        $this->questions = [];
    }

    public function add(Question $question): void
    {
        $this->questions[] = $question;
    }

    /**
     * @throws Exception
     */
    public function getRandom(): Question
    {
        return $this->questions[random_int(0, count($this->questions) - 1)];
    }
}
