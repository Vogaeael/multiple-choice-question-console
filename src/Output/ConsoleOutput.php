<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Output;

use Vogaeael\MultipleChoiceQuestionConsole\Output\OutputInterface;

class ConsoleOutput implements OutputInterface
{

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
        echo sprintf("\033[1;33m%s\033[0m%s", $question, PHP_EOL);
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
        echo "\033[0;32mThat is right!! \033[0m" . PHP_EOL . PHP_EOL;
    }

    /**
     * @inheritDoc
     */
    public function printIsWrongAnswer(string $rightAnswerKey, string $rightAnswer): void
    {
        echo sprintf("\033[0;31mThat is wrong!! The correct answer would be %s", $rightAnswerKey) . "\033[0m" . PHP_EOL . PHP_EOL;
    }
}
