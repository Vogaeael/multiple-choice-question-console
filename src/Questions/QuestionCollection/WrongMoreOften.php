<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class WrongMoreOften extends AbstractProbabilityCollection
{
    /**
     * Calculate the probability.
     * Questions answered more right than wrong, should be below 1. Questions answered more wrong than right, should be above 1.
     *
     * Example table:
     *
     * | wrong | right | probability |
     * -------------------------------
     * |   0   |   0   |      1      |
     * |   2   |   0   |      3      |
     * |   4   |   2   |      2      |
     * |   0   |   3   |     0.25    |
     * |   3   |   9   |     0.33    |
     */
    protected function calculateProbability(QuestionInterface $question): float
    {
        $howOftenRight = $question->getHowOftenRightAnswered();
        $howOftenWrong = $question->getHowOftenWrongAnswered();

        /**
         * when we calculate with 0 only right answered would never again come up and only wrong answered would be always (unlimited)
         * because of that we set them to one higher, so 3 times right and never wrong is same like 4 times right and one time wrong.
         */
        if (0 === $howOftenRight || 0 === $howOftenWrong) {
            $howOftenRight++;
            $howOftenWrong++;
        }

        if ($howOftenRight > $howOftenWrong) {
            /**
             * probability is percent of wrong (one time wrong and 3 times right => 25% => 0.25)
             */
            return $howOftenWrong / ($howOftenWrong + $howOftenRight);
        }

        /**
         * one time right and 3 times wrong => 3
         */
        return $howOftenWrong / $howOftenRight;
    }
}
