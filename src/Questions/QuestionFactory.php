<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions;

class QuestionFactory
{
    public function create(
        string $question,
        array  $wrongAnswers,
        string $rightAnswer
    ): Question
    {
        return new Question($question, $wrongAnswers, $rightAnswer);
    }
}
