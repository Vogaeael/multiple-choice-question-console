<?php

namespace unit\Output;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Vogaeael\MultipleChoiceQuestionConsole\Output\ConsoleOutput;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\Question;

class ConsoleOutputTest extends TestCase
{
    protected ConsoleOutput $output;

    public function setUp(): void
    {
        $this->output = new ConsoleOutput();
    }

    public function testPrintPossibleAnswers(): void
    {
        $expect = 'a: Answer A' . PHP_EOL . 'b: Answer B' . PHP_EOL . 'c: Answer C' . PHP_EOL;
        $answers = [
            'a' => 'Answer A',
            'b' => 'Answer B',
            'c' => 'Answer C'
        ];
        $this->expectOutputString($expect);

        $this->output->printPossibleAnswers($answers);
    }

    public function testPrintQuestion(): void
    {
        $question = 'This is a question?';
        $expect = "\033[1;33mThis is a question?\033[0m" . PHP_EOL;
        $this->expectOutputString($expect);

        $this->output->printQuestion($question);
    }

    public function testPrintNotPossibleAnswer(): void
    {
        $notPossibleAnswer = 'This answer is not possible';
        $possibleAnswers = [
            'a' => 'Possible Answer A',
            'b' => 'Possible Answer B',
            'c' => 'Possible Answer C',
        ];
        $expect = '`This answer is not possible` is not one of the possible answers a, b, c' . PHP_EOL;
        $this->expectOutputString($expect);

        $this->output->printNotPossibleAnswer($notPossibleAnswer, $possibleAnswers);
    }

    public function testPrintIsCorrectAnswer(): void
    {
        $expect = "\033[0;32mThat is correct!!\033[0m" . PHP_EOL . PHP_EOL;
        $this->expectOutputString($expect);

        $this->output->printIsCorrectAnswer();
    }

    public function testPrintIsWrongAnswer(): void
    {
        $rightAnswerKey = 'c';
        $rightAnswer = 'This is the correct answer';
        $expect = "\033[0;31mThat is wrong!! The correct answer would be c\033[0m" . PHP_EOL . PHP_EOL;
        $this->expectOutputString($expect);

        $this->output->printIsWrongAnswer($rightAnswerKey, $rightAnswer);
    }

    /**
     * @throws Exception
     */
    public function testPrintTotalResult(): void
    {
        $correctQuestionOne = $this->createMock(Question::class);
        $correctQuestionTwo = $this->createMock(Question::class);
        $correctQuestionThree = $this->createMock(Question::class);

        $wrongQuestionOne = $this->createMock(Question::class);
        $wrongQuestionTwo = $this->createMock(Question::class);

        $correctAnsweredQuestions = [
            $correctQuestionOne,
            $correctQuestionTwo,
            $correctQuestionThree,
        ];
        $wrongAnsweredQuestions = [
            $wrongQuestionOne,
            $wrongQuestionTwo,
        ];

        $expect = "\033[1;33m================================="
            . PHP_EOL . 'You have 2 from 5 questions wrong' . PHP_EOL
            . "=================================\033[0m" . PHP_EOL;
        $this->expectOutputString($expect);

        $this->output->printTotalResult($correctAnsweredQuestions, $wrongAnsweredQuestions);
    }

    public function testError(): void
    {
        $exception = new \Exception('Exception Message');
        $expect = 'Exception Message' . PHP_EOL;
        $this->expectOutputString($expect);

        $this->output->error($exception);
    }
}
