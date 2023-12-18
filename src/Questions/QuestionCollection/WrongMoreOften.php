<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\Exception\QuestionNotInListException;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionChangedSubscription\QuestionChangedWrapperFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionChangedSubscription\QuestionChangeSubscriberInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class WrongMoreOften implements QuestionCollectionInterface, QuestionChangeSubscriberInterface
{
    protected const PROBABILITY_KEY = 'probability';
    protected const QUESTION_KEY = 'question';

    /** @var array{question: QuestionInterface, probability: float} $questions */
    protected array $questions;

    public function __construct(
        protected QuestionChangedWrapperFactory $changedWrapperFactory
    ) {}

    public function add(QuestionInterface $question): void
    {
        $this->questions[] = [
            static::QUESTION_KEY => $this->changedWrapperFactory->create($question, $this),
            static::PROBABILITY_KEY => $this->calculateProbability($question),
        ];
    }

    public function getNext(): QuestionInterface
    {
        $total = $this->getSumOfProbability();
        $rand = $this->getRandomFloat(0, $total);
        $sum = 0;

        foreach ($this->questions as $question) {
            $sum += $question[static::PROBABILITY_KEY];
            if ($sum >= $rand) {
                return $question[static::QUESTION_KEY];
            }
        }

        throw new \Exception('Next Question not found with probability');
    }

    protected function getSumOfProbability(): float
    {
        $sum = 0;
        foreach ($this->questions as $question) {
            $sum += $question[static::PROBABILITY_KEY];
        }

        return $sum;
    }

    protected function getRandomFloat(float $min, float $max): float
    {
        $randomNumber = ($max -$min) * $this->getRandomFloatBetweenZeroAndOne();

        return $randomNumber + $min;
    }

    protected function getRandomFloatBetweenZeroAndOne(): float
    {
        return mt_rand() / mt_getrandmax();
    }

    public function changed(QuestionInterface $question): void
    {
        $key = $this->findQuestionKey($question);

        $this->questions[$key][static::PROBABILITY_KEY] = $this->calculateProbability($question);
    }

    /**
     * @throws QuestionNotInListException
     */
    protected function findQuestionKey(QuestionInterface $question): ?int
    {
        foreach($this->questions as $key => $questionWrapper) {
            if ($question === $questionWrapper[static::QUESTION_KEY]) {
                return $key;
            }
        }

        throw new QuestionNotInListException(sprintf('Question with question `%s` is not in the list.', $question->getQuestion()));
    }

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
