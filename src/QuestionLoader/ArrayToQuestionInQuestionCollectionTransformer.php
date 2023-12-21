<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader;

use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\Normalizer\QuestionNormalizerInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionFactory;

class ArrayToQuestionInQuestionCollectionTransformer
{
    protected const QUESTION_KEY_QUESTION_TEXT = 'questionText';
    protected const QUESTION_KEY_WRONG_ANSWERS = 'wrongAnswers';
    protected const QUESTION_KEY_CORRECT_ANSWER = 'correctAnswer';
    protected const REQUIRED_KEYS = [
        self::QUESTION_KEY_QUESTION_TEXT,
        self::QUESTION_KEY_WRONG_ANSWERS,
        self::QUESTION_KEY_CORRECT_ANSWER
    ];

    public function __construct(
        protected readonly QuestionCollectionFactory $questionCollectionFactory,
        protected readonly QuestionFactory $questionFactory
    ) {}

    /**
     * @throws Exception
     */
    public function transformToQuestions(array $questionsArray, string $collectionType): QuestionCollectionInterface {
        if (!array_key_exists('questions', $questionsArray)) {
            throw new Exception('input file has not entry `questions`');
        }
        $questionsArray = $questionsArray['questions'];
        $questions = $this->questionCollectionFactory->create($collectionType);

        foreach ($questionsArray as $questionArray) {
            try {
                $this->validateArrayKeys($questionArray);
                $wrongAnswers = $questionArray[self::QUESTION_KEY_WRONG_ANSWERS];
                if (!is_array($wrongAnswers)) {
                    $wrongAnswers = [$wrongAnswers];
                }
                $question = $this->questionFactory->create(
                    $questionArray[self::QUESTION_KEY_QUESTION_TEXT],
                    $wrongAnswers,
                    $questionArray[self::QUESTION_KEY_CORRECT_ANSWER]
                );
                $questions->add($question);
            } catch (Exception $e) {
                echo $e->getMessage() . PHP_EOL;
                continue;
            }
        }

        return $questions;
    }

    /**
     * @throws Exception
     */
    protected function validateArrayKeys(array $questionArray): void
    {
        foreach(self::REQUIRED_KEYS as $requiredKey) {
            $this->validateArrayForKey($questionArray, $requiredKey);
        }
    }

    /**
     * @throws Exception
     */
    protected function validateArrayForKey(array $questionArray, string $key): void
    {
        if (!array_key_exists($key, $questionArray)) {
            throw new Exception(sprintf('Array has not the key %s', $key));
        }
    }
}
