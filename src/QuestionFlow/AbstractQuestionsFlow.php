<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow;

use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\AnswerRandomizer;
use Vogaeael\MultipleChoiceQuestionConsole\Input\InputInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Output\OutputInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\Exception\QuestionCollectionEmptyException;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

abstract class AbstractQuestionsFlow implements QuestionFlowInterface
{
    protected const EXIT_CODE = 'exit';

    protected QuestionCollectionInterface $questions;
    protected QuestionInterface $currentQuestion;

    /** @var array<string, string> $possibleAnswers */
    protected array $possibleAnswers;
    protected string $correctAnswerKey;

    protected bool $doExit = false;

    public function __construct(
        protected readonly AnswerRandomizer $answerRandomizer,
        protected readonly OutputInterface  $output,
        protected readonly InputInterface $input
    ) {}

    public function run(QuestionCollectionInterface $questions): void
    {
        $this->questions = $questions;
        do {
            $this->doNextQuestion();
        } while(!$this->doExit);
    }

    /**
     * Do current question.
     *
     * @throws Exception
     */
    protected function doNextQuestion(): void
    {
        try {
            $this->currentQuestion = $this->questions->getNext();
            $this->determineAnswers();
            $this->output->printQuestion($this->currentQuestion->getQuestion());
            $this->output->printPossibleAnswers($this->possibleAnswers);

            do {
                $finishedQuestion = $this->handleAnswersOfCurrentQuestion();
            } while(!$finishedQuestion && !$this->doExit);
        } catch (QuestionCollectionEmptyException $e) {
            $this->handleCollectionEmptyException($e);
        }
    }

    /**
     * Handle the question answer. Rotate as long as no exit or possible answer.
     *
     * @return bool
     */
    protected function handleAnswersOfCurrentQuestion(): bool
    {
        do {
            $finishedQuestion = false;
            $answer = $this->input->getAnswer();
            if (static::EXIT_CODE === $answer) {
                $this->doExit = true;

                return false;
            }
            if (!in_array($answer, array_keys($this->possibleAnswers))) {
                $this->output->printNotPossibleAnswer($answer, $this->possibleAnswers);
                continue;
            }
            $finishedQuestion = true;

            if ($answer === $this->correctAnswerKey) {
                $this->handleRightAnswer();
                continue;
            }

            $this->handleWrongAnswer();
        } while(!$finishedQuestion);

        return true;
    }

    protected function handleRightAnswer(): void
    {
        $this->currentQuestion->increaseCorrectAnswered();
    }

    protected function handleWrongAnswer(): void
    {
        $this->currentQuestion->increaseWrongAnswered();
    }

    /**
     * @throws Exception
     */
    protected function determineAnswers(): void
    {
        $possibleAnswersWrapper = $this->answerRandomizer->randomizeAnswers($this->currentQuestion);
        $this->possibleAnswers = $possibleAnswersWrapper['answers'];
        $this->correctAnswerKey = $possibleAnswersWrapper['correctAnswerKey'];
    }

    protected function handleCollectionEmptyException(QuestionCollectionEmptyException $exception): void
    {
        $this->output->error($exception);
    }
}
