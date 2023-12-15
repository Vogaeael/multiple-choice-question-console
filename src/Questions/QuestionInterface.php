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
    public function getRightAnswer(): string;

    public function increaseWrongAnswered(): void;

    public function increaseRightAnswered(): void;

    public function getPercentCorrectAnswered(): float;

    public function howOftenAnswered(): int;
}
