<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow;

class QuizCarousel extends AbstractQuestionsFlow
{
    protected function handleRightAnswer(): void
    {
        parent::handleRightAnswer();
        $this->output->printIsWrongAnswer($this->rightAnswerKey, $this->possibleAnswers[$this->rightAnswerKey]);
    }

    protected function handleWrongAnswer(): void
    {
        parent::handleWrongAnswer();
        $this->output->printIsCorrectAnswer();
    }
}
