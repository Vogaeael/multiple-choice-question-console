<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions;

class Question implements QuestionInterface
{
    private string $question;
    /** @var string[] $wrongAnswers */
    private array $wrongAnswers;
    private string $correctAnswer;
    private int $howOftenWrongAnswered;
    private int $howOftenCorrectAnswered;

    /**
     * @param string[] $wrongAnswers
     */
    public function __construct(
        string $question,
        array $wrongAnswers,
        string $correctAnswer,
        int $wrongAnswered = 0,
        int $correctAnswered = 0
    ) {
        $this->question = $question;
        $this->wrongAnswers = $wrongAnswers;
        $this->correctAnswer = $correctAnswer;
        $this->howOftenWrongAnswered = $wrongAnswered;
        $this->howOftenCorrectAnswered = $correctAnswered;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @inheritDoc
     */
    public function getWrongAnswers(): array
    {
        return $this->wrongAnswers;
    }

    public function getCorrectAnswer(): string
    {
        return $this->correctAnswer;
    }

    public function increaseWrongAnswered(): void
    {
        $this->howOftenWrongAnswered++;
    }

    public function increaseCorrectAnswered(): void
    {
        $this->howOftenCorrectAnswered++;
    }

    public function getHowOftenCorrectAnswered(): int
    {
        return $this->howOftenCorrectAnswered;
    }

    public function getHowOftenWrongAnswered(): int
    {
        return $this->howOftenWrongAnswered;
    }

    public function howOftenAnswered(): int
    {
        return $this->howOftenCorrectAnswered + $this->howOftenWrongAnswered;
    }
}
