<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Output;

use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

interface OutputInterface
{
    /**
     * Print the possible answers to the output
     *
     * @param array<string, string> $answers
     */
    public function printPossibleAnswers(array $answers): void;

    /**
     * Print the question to the output
     */
    public function printQuestion(string $question): void;

    /**
     * Print that the answer is not one of the possible
     *
     * @param array<string, string> $possibleAnswers
     */
    public function printNotPossibleAnswer(string $answer, array $possibleAnswers): void;

    /**
     * Print that it was the correct answer
     */
    public function printIsCorrectAnswer(): void;

    /**
     * Print that it was the wrong answer and what the right answer was
     */
    public function printIsWrongAnswer(string $correctAnswerKey, string $correctAnswer): void;

    /**
     * Print the total result of right and wrong answered questions.
     *
     * @param QuestionInterface[] $correctAnsweredQuestions
     * @param QuestionInterface[] $wrongAnsweredQuestions
     */
    public function printTotalResult(array $correctAnsweredQuestions, array $wrongAnsweredQuestions): void;

    /**
     * Print that we had an error and also the error message
     */
    public function error(Exception $exception): void;
}
