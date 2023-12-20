<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions;

interface QuestionInterface
{
    /**
     * @return string
     */
    public function getQuestion(): string;

    /**
     * @return array
     */
    public function getWrongAnswers(): array;

    /**
     * @return string
     */
    public function getCorrectAnswer(): string;

    public function increaseWrongAnswered(): void;

    public function increaseCorrectAnswered(): void;

    public function getHowOftenCorrectAnswered(): int;

    public function getHowOftenWrongAnswered(): int;

    public function howOftenAnswered(): int;
}
