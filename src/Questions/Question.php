<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions;

class Question implements QuestionInterface
{
    private string $question;
    /** @var string[] $wrongAnswers */
    private array $wrongAnswers;
    private string $rightAnswer;
    private int $wrongAnswered;
    private int $rightAnswered;

    public function __construct(
        string $question,
        array $wrongAnswers,
        string $rightAnswer,
        int $wrongAnswered = 0,
        int $rightAnswered = 0
    ) {
        $this->question = $question;
        $this->wrongAnswers = $wrongAnswers;
        $this->rightAnswer = $rightAnswer;
        $this->wrongAnswered = $wrongAnswered;
        $this->rightAnswered = $rightAnswered;
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

    public function increaseWrongAnswered(): void
    {
        $this->wrongAnswered++;
    }

    public function increaseRightAnswered(): void
    {
        $this->rightAnswered++;
    }

    public function getPercentCorrectAnswered(): float
    {
        if (0 === $this->rightAnswered) {
            return 0;
        }

        return ($this->rightAnswered / ($this->rightAnswered + $this->wrongAnswered)) * 100;
    }

    public function howOftenAnswered(): int
    {
        return $this->rightAnswered + $this->wrongAnswered;
    }
}
