<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\Exception\QuestionCollectionEmptyException;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class AllOneTime implements QuestionCollectionInterface
{
    private array $notDoneQuestions;

    public function __construct()
    {
        $this->notDoneQuestions = [];
    }

    public function add(QuestionInterface $question): void
    {
        $this->notDoneQuestions[] = $question;
    }

    public function getNext(): QuestionInterface
    {
        $numberNotDoneQuestions = count($this->notDoneQuestions);
        if (0 === $numberNotDoneQuestions) {
            throw new QuestionCollectionEmptyException('All questions answered already');
        }
        $key = random_int(0, $numberNotDoneQuestions - 1);
        $nextQuestion = $this->notDoneQuestions[$key];
        unset($this->notDoneQuestions[$key]);
        $this->notDoneQuestions = array_values($this->notDoneQuestions);

        return $nextQuestion;
    }
}
