<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader;

use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\Output\OutputInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionInterface;

class ArrayToQuestionCollectionTransformer
{
    public function __construct(
        protected readonly QuestionCollectionFactory $questionCollectionFactory,
        protected readonly ArrayToQuestionTransformer $questionTransformer,
        protected readonly OutputInterface $output
    ) {}

    /**
     * @param array{
     *      questions: array<int, array{
     *           questionText: string,
     *           wrongAnswers: string|array<int, string>,
     *           correctAnswer: string
     *      }>
     *  } $questionsArray
     *
     * @throws Exception
     */
    public function transformToQuestionsCollection(array $questionsArray, string $collectionType): QuestionCollectionInterface {
        if (!array_key_exists('questions', $questionsArray)) {
            throw new Exception('input file has not entry `questions`');
        }
        $questionsArray = $questionsArray['questions'];
        $questions = $this->questionCollectionFactory->create($collectionType);

        foreach ($questionsArray as $questionArray) {
            try {
                $question = $this->questionTransformer->transform($questionArray);
                $questions->add($question);
            } catch (Exception $e) {
                $this->output->error($e);
                continue;
            }
        }

        return $questions;
    }
}
