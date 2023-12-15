<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader;


use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\Normalizer\QuestionNormalizerInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionInterface;

class FileQuestionLoader implements QuestionLoaderInterface
{
    protected const QUESTION_KEY_QUESTION_TEXT = 'questionText';
    protected const QUESTION_KEY_WRONG_ANSWERS = 'wrongAnswers';
    protected const QUESTION_KEY_RIGHT_ANSWER = 'rightAnswer';
    protected const REQUIRED_KEYS = [
        self::QUESTION_KEY_QUESTION_TEXT,
        self::QUESTION_KEY_WRONG_ANSWERS,
        self::QUESTION_KEY_RIGHT_ANSWER
    ];

    public function __construct(
        protected readonly QuestionCollectionFactory $questionCollectionFactory,
        protected readonly QuestionFactory $questionFactory,
        protected readonly QuestionNormalizerInterface $normalizer
    ) {}

    /**
     * @throws Exception
     */
    public function load(string $path, string $type): QuestionCollectionInterface
    {
        $this->validateFileExistAndReadable($path);
        $questionsArray = $this->getContent($path);

        return $this->transformToQuestions($questionsArray, $type);
    }

    /**
     * @throws Exception
     */
    protected function validateFileExistAndReadable(string $path): void
    {
        if (!file_exists($path)) {
            throw new Exception(sprintf('File `%s` does not exist', $path));
        }
        if (!is_file($path)) {
            throw new Exception(sprintf('`%s` is not a file', $path));
        }
        if (!is_readable($path)) {
            throw new Exception(sprintf('File `%s` is not readable', $path));
        }
    }

    protected function getContent(string $path): array
    {
        $content = file_get_contents($path);

        return $this->normalizer->normalize($content);
    }

    /**
     * @throws Exception
     */
    protected function transformToQuestions(array $questionsArray, string $type): QuestionCollectionInterface {
        if (!array_key_exists('questions', $questionsArray)) {
            throw new Exception('input file has not entry `questions`');
        }
        $questionsArray = $questionsArray['questions'];
        $questions = $this->questionCollectionFactory->create($type);

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
                    $questionArray[self::QUESTION_KEY_RIGHT_ANSWER]
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
