<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class WrongMoreOften extends AbstractProbabilityCollection
{
    /**
     * Calculate the probability.
     * Questions answered more correct than wrong, should be below 1. Questions answered more wrong than correct, should be above 1.
     *
     * Example table:
     *
     * | wrong | correct | probability |
     * -------------------------------
     * |   0   |    0    |      1      |
     * |   2   |    0    |      3      |
     * |   4   |    2    |      2      |
     * |   0   |    3    |     0.25    |
     * |   3   |    9    |     0.33    |
     */
    protected function calculateProbability(QuestionInterface $question): float
    {
        $howOftenCorrectAnswered = $question->getHowOftenCorrectAnswered();
        $howOftenWrong = $question->getHowOftenWrongAnswered();

        /**
         * when we calculate with 0 only correct answered would never again come up and only wrong answered would be always (unlimited)
         * because of that we set them to one higher, so 3 times correct and never wrong is same like 4 times correct and one time wrong.
         */
        if (0 === $howOftenCorrectAnswered || 0 === $howOftenWrong) {
            $howOftenCorrectAnswered++;
            $howOftenWrong++;
        }

        if ($howOftenCorrectAnswered > $howOftenWrong) {
            /**
             * probability is percent of wrong (one time wrong and 3 times correct => 25% => 0.25)
             */
            return $howOftenWrong / ($howOftenWrong + $howOftenCorrectAnswered);
        }

        /**
         * one time correct and 3 times wrong => 3
         */
        return $howOftenWrong / $howOftenCorrectAnswered;
    }
}
