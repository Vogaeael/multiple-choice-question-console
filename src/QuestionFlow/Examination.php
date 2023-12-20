<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\Exception\QuestionCollectionEmptyException;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class Examination extends AbstractQuestionsFlow
{
    /** @var QuestionInterface[] $correctAnsweredQuestions */
    protected array $correctAnsweredQuestions = [];
    /** @var QuestionInterface[] $wrongAnsweredQuestions */
    protected array $wrongAnsweredQuestions = [];

    public function run(QuestionCollectionInterface $questions): void
    {
        parent::run($questions);
        $this->output->printTotalResult($this->correctAnsweredQuestions, $this->wrongAnsweredQuestions);
    }

    protected function handleRightAnswer(): void
    {
        parent::handleRightAnswer();
        $this->correctAnsweredQuestions[] = $this->currentQuestion;
    }

    protected function handleWrongAnswer(): void
    {
        parent::handleWrongAnswer();
        $this->wrongAnsweredQuestions[] = $this->currentQuestion;
    }

    protected function handleCollectionEmptyException(QuestionCollectionEmptyException $exception): void
    {
        $this->doExit = true;
    }
}
