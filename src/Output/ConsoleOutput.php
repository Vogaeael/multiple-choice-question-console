<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Output;

class ConsoleOutput implements OutputInterface
{
    private const DEFAULT = "\033[0m";
    private const RED = "\033[0;31m";
    private const GREEN = "\033[0;32m";
    private const YELLOW = "\033[1;33m";

    /**
     * @inheritDoc
     */
    public function printPossibleAnswers(array $answers): void
    {
        foreach ($answers as $key => $answer) {
            echo sprintf('%s: %s', $key, $answer) . PHP_EOL;
        }
    }

    /**
     * @inheritDoc
     */
    public function printQuestion(string $question): void
    {
        echo sprintf('%s%s%s%s', self::YELLOW, $question, self::DEFAULT, PHP_EOL);
    }

    /**
     * @inheritDoc
     */
    public function printNotPossibleAnswer(string $answer, array $possibleAnswers): void
    {
        echo sprintf('`%s` is not one of the possible answers %s%s', $answer, implode(', ', array_keys($possibleAnswers)), PHP_EOL);
    }

    /**
     * @inheritDoc
     */
    public function printIsCorrectAnswer(): void
    {
        echo sprintf('%sThat is correct!!%s%s%s', self::GREEN, self::DEFAULT, PHP_EOL, PHP_EOL);
    }

    /**
     * @inheritDoc
     */
    public function printIsWrongAnswer(string $correctAnswerKey, string $correctAnswer): void
    {
        echo sprintf('%sThat is wrong!! The correct answer would be %s%s%s%s', self::RED, $correctAnswerKey, self::DEFAULT, PHP_EOL, PHP_EOL);
    }

    /**
     * @inheritDoc
     */
    public function printTotalResult(array $correctAnsweredQuestions, array $wrongAnsweredQuestions): void
    {
        $countWrongAnswers = count($wrongAnsweredQuestions);
        $countAnswers = count($correctAnsweredQuestions) + $countWrongAnswers;
        $message = sprintf('You have %d from %d questions wrong', $countWrongAnswers, $countAnswers);
        $upperAndUnderline = str_repeat('=', strlen($message));
        echo sprintf('%s%s%s', self::YELLOW, $upperAndUnderline, PHP_EOL);
        echo sprintf('%s%s', $message, PHP_EOL);
        echo sprintf('%s%s%s', $upperAndUnderline, self::DEFAULT, PHP_EOL);
    }

    /**
     * @inheritDoc
     */
    public function error(\Exception $exception): void
    {
        echo $exception->getMessage() . PHP_EOL;
    }
}
