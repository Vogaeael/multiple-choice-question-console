<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions;

interface QuestionInterface
{
    public function getQuestion(): string;

    /**
     * @return string[]
     */
    public function getWrongAnswers(): array;

    public function getCorrectAnswer(): string;

    public function increaseWrongAnswered(): void;

    public function increaseCorrectAnswered(): void;

    public function getHowOftenCorrectAnswered(): int;

    public function getHowOftenWrongAnswered(): int;

    public function howOftenAnswered(): int;
}
