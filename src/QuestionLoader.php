<?php

namespace Vogaeael\MultipleChoiceQuestionConsole;


use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollectionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionFactory;

class QuestionLoader
{
    private const QUESTION_KEY_QUESTION_TEXT = 'questionText';
    private const QUESTION_KEY_WRONG_ANSWERS = 'wrongAnswers';
    private const QUESTION_KEY_RIGHT_ANSWER = 'rightAnswer';
    private const REQUIRED_KEYS = [
        self::QUESTION_KEY_QUESTION_TEXT,
        self::QUESTION_KEY_WRONG_ANSWERS,
        self::QUESTION_KEY_RIGHT_ANSWER
    ];

    private QuestionCollectionFactory $questionCollectionFactory;
    private QuestionFactory $questionFactory;

    public function __construct(
        QuestionCollectionFactory $questionCollectionFactory,
        QuestionFactory $questionFactory,
    ) {
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->questionFactory = $questionFactory;
    }

    /**
     * @throws Exception
     */
    public function load(string $path): QuestionCollection
    {
        $this->validateFileExistAndReadable($path);
        $questionsArray = $this->getContent($path);

        return $this->transformToQuestions($questionsArray);
    }

    /**
     * @throws Exception
     */
    private function validateFileExistAndReadable(string $path): void
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

    private function getContent(string $path): array
    {
        $content = file_get_contents($path);

        return json_decode($content, true);
    }

    /**
     * @throws Exception
     */
    private function transformToQuestions(array $questionsArray): QuestionCollection {
        if (!array_key_exists('questions', $questionsArray)) {
            throw new Exception('input file has not entry `questions`');
        }
        $questionsArray = $questionsArray['questions'];
        $questions = $this->questionCollectionFactory->create();

        foreach ($questionsArray as $questionArray) {
            try {
                $this->validateArrayKeys($questionArray);
                $question = $this->questionFactory->create(
                    $questionArray[self::QUESTION_KEY_QUESTION_TEXT],
                    $questionArray[self::QUESTION_KEY_WRONG_ANSWERS],
                    $questionArray[self::QUESTION_KEY_RIGHT_ANSWER]
                );
                $questions->add($question);
            } catch (Exception $e) {
                echo $e->getMessage();
                continue;
            }
        }

        return $questions;
    }

    /**
     * @throws Exception
     */
    private function validateArrayKeys(array $questionArray): void
    {
        foreach(self::REQUIRED_KEYS as $requiredKey) {
            $this->validateArrayForKey($questionArray, $requiredKey);
        }
    }

    /**
     * @throws Exception
     */
    private function validateArrayForKey(array $questionArray, string $key): void
    {
        if (!array_key_exists($key, $questionArray)) {
            throw new Exception(sprintf('Array has not the key %s', $key));
        }
    }
}
