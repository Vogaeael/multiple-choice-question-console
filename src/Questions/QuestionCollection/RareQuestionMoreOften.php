<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class RareQuestionMoreOften extends AbstractProbabilityCollection
{
    protected function calculateProbability(QuestionInterface $question): float
    {
        return 1 / ($question->getHowOftenCorrectAnswered() + $question->getHowOftenWrongAnswered());
    }
}
