<?php

namespace unit\QuestionFlow;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Vogaeael\MultipleChoiceQuestionConsole\AnswerRandomizer;
use Vogaeael\MultipleChoiceQuestionConsole\Input\InputInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Output\OutputInterface;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow\Examination;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\Question;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionInterface;

class ExaminationTest extends TestCase
{
    protected const QUESTIONS = [
        [
            'firstQuestion' => [
                'question' => 'Question one?',
                'correctAnswer' => 'c',
                'answers' => [
                    'a' => 'wrong answer a.',
                    'b' => 'wrong answer b.',
                    'c' => 'correct answer.',
                    'd' => 'wrong answer d.',
                ],
            ],
            'lastQuestion' => [
                'question' => 'Question two?',
                'correctAnswer' => 'b',
                'answers' => [
                    'a' => 'wrong answer a.',
                    'b' => 'correct answer.',
                    'c' => 'wrong answer c.',
                    'd' => 'wrong answer d.',
                ],
            ],
        ],
        [
            'firstQuestion' => [
                'question' => 'Question three?',
                'correctAnswer' => 'e',
                'answers' => [
                    'a' => 'wrong answer a.',
                    'b' => 'wrong answer b.',
                    'c' => 'wrong answer c.',
                    'd' => 'wrong answer d.',
                    'e' => 'correct answer.',
                ],
            ],
            'lastQuestion' => [
                'question' => 'Question four?',
                'correctAnswer' => 'a',
                'answers' => [
                    'a' => 'correct answer.',
                    'b' => 'wrong answer b.',
                    'c' => 'wrong answer c.',
                ],
            ],
        ],
    ];

    protected AnswerRandomizer & MockObject $answerRandomizer;
    protected OutputInterface & MockObject $output;
    protected InputInterface & MockObject$input;
    protected QuestionCollectionInterface & MockObject $questionCollection;
    protected Examination $examination;

    /**
     * @return array<int, array<string, array<int, array<string, array{question: string, correctAnswer: string, answers: array<string, string>}>>>>
     */
    static public function questionsDataProvider(): array
    {
        $questions = [];
        foreach (static::QUESTIONS as$question) {
            $questions[] = [$question];
        }

        return $questions;
    }

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->answerRandomizer = $this->createMock(AnswerRandomizer::class);
        $this->output = $this->createMock(OutputInterface::class);
        $this->input = $this->createMock(InputInterface::class);
        $this->questionCollection = $this->createMock(QuestionCollectionInterface::class);

        $this->examination = new Examination($this->answerRandomizer, $this->output, $this->input);
    }

    /**
     * @param array<string, array{question: string, correctAnswer: string, answers: array<string, string>}> $questionArray
     *
     * @throws Exception
     */
    #[DataProvider('questionsDataProvider')]
    public function testRightAnswer(array $questionsArray): void
    {
        // @TODO improve for multiple questions
        $questions = [];
        foreach ($questionsArray as $key => $questionArray) {
            $question = $this->createMock(Question::class);
            $question->method('getQuestion')
                ->willReturn($questionArray['question']);
            // @TODO not last one
            $question->expects($this->once())
                ->method('increaseCorrectAnswered');
            $questions[] = $question;
        }

        $this->answerRandomizer->method('randomizeAnswers')
            ->with([$question])
            ->willReturn([
                'answers' => $questionArray['answers'],
                'correctAnswerKey' => $questionArray['correctAnswer'],
            ]);
        $this->questionCollection->expects($this->exactly(2))
            ->method('getNext')
            ->willReturn(...$questions);
        $this->output->expects($this->exactly(2))
            ->method('printQuestion')
            ->with([$questionArray['question']]);   // @TODO change for following params
        $this->output->expects($this->exactly(2))
            ->method('printPossibleAnswers')
            ->with([$questionArray['answers']]);    // @TODO change for following params
        $this->output->expects($this->once())
            ->method('printTotalResult')
            ->with([[], []]);   // @TODO add correct answers
        $this->input->expects($this->exactly(2))
            ->method('getAnswer')
            ->willReturnOnConsecutiveCalls([$questionArray['correctAnswer'], 'exit']);


        $this->markTestIncomplete('This test has not been implemented.');

        $this->examination->run($this->questionCollection);
    }

    public function testWrongAnswer(): void
    {
        $this->markTestIncomplete('This test has not been implemented.');
        // @TODO
    }

    public function testNotPossibleAnswer(): void
    {
        $this->markTestIncomplete('This test has not been implemented.');
        // @TODO
    }

    public function testRunEndWithExit(): void
    {
        $this->markTestIncomplete('This test has not been implemented.');
        // @TODO
    }

    public function testRunEndWithAllUsed(): void
    {
        $this->markTestIncomplete('This test has not been implemented.');
        // @TODO
    }
}
