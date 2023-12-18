<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow;

class QuizCarousel extends AbstractQuestionsFlow
{
    protected function handleRightAnswer(): void
    {
        parent::handleRightAnswer();
        $this->output->printIsCorrectAnswer();
    }

    protected function handleWrongAnswer(): void
    {
        parent::handleWrongAnswer();
        $this->output->printIsWrongAnswer($this->rightAnswerKey, $this->possibleAnswers[$this->rightAnswerKey]);
    }
}
