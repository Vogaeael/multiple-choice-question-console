<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions;

class Question
{
    private string $question;
    /** @var string[] $wrongAnswers */
    private array $wrongAnswers;
    private string $rightAnswer;

    public function __construct(
        string $question,
        array $wrongAnswers,
        string $rightAnswer
    ) {
        $this->question = $question;
        $this->wrongAnswers = $wrongAnswers;
        $this->rightAnswer = $rightAnswer;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return array
     */
    public function getWrongAnswers(): array
    {
        return $this->wrongAnswers;
    }

    /**
     * @return string
     */
    public function getRightAnswer(): string
    {
        return $this->rightAnswer;
    }
}
