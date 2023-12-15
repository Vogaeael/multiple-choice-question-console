<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollection;

interface QuestionFlowInterface
{
    public function run(QuestionCollection $questions): void;
}
