<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader;

use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class ArrayToQuestionTransformer
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
        protected readonly QuestionFactory $questionFactory
    ) {}

    /**
     * @param array $questionArray
     *
     * @throws Exception
     */
    public function transform(array $questionArray): QuestionInterface
    {

        $this->validateArrayKeys($questionArray);
        $wrongAnswers = $questionArray[self::QUESTION_KEY_WRONG_ANSWERS];
        if (!is_array($wrongAnswers)) {
            $wrongAnswers = [$wrongAnswers];
        }
        return $this->questionFactory->create(
            $questionArray[self::QUESTION_KEY_QUESTION_TEXT],
            $wrongAnswers,
            $questionArray[self::QUESTION_KEY_CORRECT_ANSWER]
        );
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
