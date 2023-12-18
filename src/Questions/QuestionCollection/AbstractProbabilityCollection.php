<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;

use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\Exception\QuestionNotInListException;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionChangedSubscription\QuestionChangedWrapperFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionChangedSubscription\QuestionChangeSubscriberInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

abstract class AbstractProbabilityCollection implements QuestionCollectionInterface, QuestionChangeSubscriberInterface
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

    /**
     * @throws Exception
     */
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

        throw new Exception('Next Question not found with probability');
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

    /**
     * @throws QuestionNotInListException
     */
    public function changed(QuestionInterface $question): void
    {
        $key = $this->findQuestionKey($question);
        $this->updateProbability($key);
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

    protected function updateProbability(int $questionKey): void
    {
        $this->questions[$questionKey][static::PROBABILITY_KEY] = $this->calculateProbability($this->questions[$questionKey][static::QUESTION_KEY]);
    }

    abstract protected function calculateProbability(QuestionInterface $question): float;
}
