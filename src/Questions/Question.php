<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions;

class Question implements QuestionInterface
{
    private string $question;
    /** @var string[] $wrongAnswers */
    private array $wrongAnswers;
    private string $rightAnswer;
    private int $howOftenWrongAnswered;
    private int $howOftenRightAnswered;

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
        $this->howOftenWrongAnswered = $wrongAnswered;
        $this->howOftenRightAnswered = $rightAnswered;
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
        $this->howOftenWrongAnswered++;
    }

    public function increaseRightAnswered(): void
    {
        $this->howOftenRightAnswered++;
    }

    public function getHowOftenRightAnswered(): int
    {
        return $this->howOftenRightAnswered;
    }

    public function getHowOftenWrongAnswered(): int
    {
        return $this->howOftenWrongAnswered;
    }

    public function howOftenAnswered(): int
    {
        return $this->howOftenRightAnswered + $this->howOftenWrongAnswered;
    }
}
