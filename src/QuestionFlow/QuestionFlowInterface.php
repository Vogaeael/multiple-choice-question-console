<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionInterface;

interface QuestionFlowInterface
{
    public function run(QuestionCollectionInterface $questions): void;
}
