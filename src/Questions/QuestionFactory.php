<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions;

class QuestionFactory
{
    /**
     * @param string[] $wrongAnswers
     */
    public function create(
        string $question,
        array $wrongAnswers,
        string $correctAnswer,
        int $wrongAnswered = 0,
        int $correctAnswered = 0
    ): QuestionInterface
    {
        return new Question($question, $wrongAnswers, $correctAnswer, $wrongAnswered, $correctAnswered);
    }
}
