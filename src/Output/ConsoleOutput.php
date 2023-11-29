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
        echo sprintf('%sThat is right!!%s%s%s', self::GREEN, self::DEFAULT, PHP_EOL, PHP_EOL);
    }

    /**
     * @inheritDoc
     */
    public function printIsWrongAnswer(string $rightAnswerKey, string $rightAnswer): void
    {
        echo sprintf('%sThat is wrong!! The correct answer woudl be %s%s%s%s', self::RED, $rightAnswerKey, self::DEFAULT, PHP_EOL, PHP_EOL);
    }
}
