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
        foreach (static::QUESTIONS as $question) {
            $questions[] = [$question];
        }

        return $questions;
    }

    /**
     * @return array<int, array<string, array<int, array<string, array{question: string, correctAnswer: string, answers: array<string, string>}>>>>
     */
    static public function allQuestionsDataProvider(): array
    {
        $questions = [];
        foreach (static::QUESTIONS as $question) {
            $question[] = $question;
        }

        return [$questions];
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
     * @param array<string, array{question: string, correctAnswer: string, answers: array<string, string>}> $questionsArray
     *
     * @throws Exception
     */
    #[DataProvider('questionsDataProvider')]
    public function testCorrectAnswer(array $questionsArray): void
    {
        $firstKey = array_keys($questionsArray)[0];
        $secondKey = array_keys($questionsArray)[1];
        $questionArray = $questionsArray[$firstKey];
        $nextQuestionArray = $questionsArray[$secondKey];

        $question = $this->createMock(Question::class);
        $question->method('getQuestion')
            ->willReturn($questionArray['question']);
        $question->expects($this->once())
            ->method('increaseCorrectAnswered');
        $question->expects($this->never())
            ->method('increaseWrongAnswered');

        $nextQuestion = $this->createMock(Question::class);
        $nextQuestion->method('getQuestion')
            ->willReturn($nextQuestionArray['question']);
        $nextQuestion->expects($this->never())
            ->method('increaseCorrectAnswered');
        $nextQuestion->expects($this->never())
            ->method('increaseWrongAnswered');

        $this->answerRandomizer->method('randomizeAnswers')
            ->willReturnMap([
                [
                    $question,
                    [
                        'answers' => $questionArray['answers'],
                        'correctAnswerKey' => $questionArray['correctAnswer'],
                    ],
                ],
                [
                    $nextQuestion,
                    [
                        'answers' => $nextQuestionArray['answers'],
                        'correctAnswerKey' => $nextQuestionArray['correctAnswer'],
                    ],
                ],
            ]);

        $this->questionCollection->expects($this->exactly(2))
            ->method('getNext')
            ->willReturn($question, $nextQuestion);

        $this->output->expects($this->exactly(2))
            ->method('printQuestion')
            ->willReturnCallback(function(string $question) {
                $this->isOneOfQuestions($question);
            });
        $this->output->expects($this->exactly(2))
            ->method('printPossibleAnswers')
            ->willReturnCallback(function(array $possibleAnswers) {
                $this->isOneOfPossibleAnswerArrays($possibleAnswers);
            });
        $this->output->expects($this->once())
            ->method('printTotalResult')
            ->with([$question], []);
        $this->input->expects($this->exactly(2))
            ->method('getAnswer')
            ->willReturnOnConsecutiveCalls($questionArray['correctAnswer'], 'exit');

        $this->examination->run($this->questionCollection);
    }

    /**
     * @param array<string, array{question: string, correctAnswer: string, answers: array<string, string>}> $questionsArray
     *
     * @throws Exception
     */
    #[DataProvider('questionsDataProvider')]
    public function testWrongAnswer(array $questionsArray): void
    {
        $firstKey = array_keys($questionsArray)[0];
        $secondKey = array_keys($questionsArray)[1];
        $questionArray = $questionsArray[$firstKey];
        $nextQuestionArray = $questionsArray[$secondKey];

        $question = $this->createMock(Question::class);
        $question->method('getQuestion')
            ->willReturn($questionArray['question']);
        $question->expects($this->never())
            ->method('increaseCorrectAnswered');
        $question->expects($this->once())
            ->method('increaseWrongAnswered');

        $nextQuestion = $this->createMock(Question::class);
        $nextQuestion->method('getQuestion')
            ->willReturn($nextQuestionArray['question']);
        $nextQuestion->expects($this->never())
            ->method('increaseCorrectAnswered');
        $nextQuestion->expects($this->never())
            ->method('increaseWrongAnswered');

        $this->answerRandomizer->method('randomizeAnswers')
            ->willReturnMap([
                [
                    $question,
                    [
                        'answers' => $questionArray['answers'],
                        'correctAnswerKey' => $questionArray['correctAnswer'],
                    ],
                ],
                [
                    $nextQuestion,
                    [
                        'answers' => $nextQuestionArray['answers'],
                        'correctAnswerKey' => $nextQuestionArray['correctAnswer'],
                    ],
                ],
            ]);

        $this->questionCollection->expects($this->exactly(2))
            ->method('getNext')
            ->willReturn($question, $nextQuestion);

        $this->output->expects($this->exactly(2))
            ->method('printQuestion')
            ->willReturnCallback(function(string $question) {
                $this->isOneOfQuestions($question);
            });
        $this->output->expects($this->exactly(2))
            ->method('printPossibleAnswers')
            ->willReturnCallback(function(array $possibleAnswers) {
                $this->isOneOfPossibleAnswerArrays($possibleAnswers);
            });
        $this->output->expects($this->once())
            ->method('printTotalResult')
            ->with([], [$question]);

        $wrongAnswerKey = '';
        foreach (array_keys($questionArray['answers']) as $key) {
            if ($key !== $questionArray['correctAnswer']) {
                $wrongAnswerKey = $key;
                break;
            }
        }
        $this->input->expects($this->exactly(2))
            ->method('getAnswer')
            ->willReturnOnConsecutiveCalls($wrongAnswerKey, 'exit');

        $this->examination->run($this->questionCollection);
    }

    /**
     * @param array<string, array{question: string, correctAnswer: string, answers: array<string, string>}> $questionsArray
     *
     * @throws Exception
     */
    #[DataProvider('allQuestionsDataProvider')]
    public function testMultipleQuestions(array $questionsArray): void
    {
        $firstKey = array_keys($questionsArray)[0];
        $secondKey = array_keys($questionsArray)[1];
        $thirdKey = array_keys($questionsArray)[2];
        $fourthKey = array_keys($questionsArray)[3];
        $firstQuestionArray = $questionsArray[$firstKey];
        $secondQuestionArray = $questionsArray[$secondKey];
        $thirdQuestionArray = $questionsArray[$thirdKey];
        $fourthQuestionArray = $questionsArray[$fourthKey];

        $question = $this->createMock(Question::class);
        $question->method('getQuestion')
            ->willReturn($firstQuestionArray['question']);
        $question->expects($this->never())
            ->method('increaseCorrectAnswered');
        $question->expects($this->once())
            ->method('increaseWrongAnswered');
        // @TODO 1 right, one wrong 1 right again


        $this->markTestIncomplete('This test has not been implemented.');
        // @TODO
    }

    /**
     * @param array<string, array{question: string, correctAnswer: string, answers: array<string, string>}> $questionArray
     *
     * @throws Exception
     */
    #[DataProvider('questionsDataProvider')]
    public function testNotPossibleAnswer(array $questionsArray): void
    {
        $firstKey = array_keys($questionsArray)[0];
        $secondKey = array_keys($questionsArray)[1];
        $questionArray = $questionsArray[$firstKey];
        $nextQuestionArray = $questionsArray[$secondKey];

        $question = $this->createMock(Question::class);
        $question->method('getQuestion')
            ->willReturn($questionArray['question']);
        $question->expects($this->once())
            ->method('increaseCorrectAnswered');
        $question->expects($this->never())
            ->method('increaseWrongAnswered');

        $nextQuestion = $this->createMock(Question::class);
        $nextQuestion->method('getQuestion')
            ->willReturn($nextQuestionArray['question']);
        $nextQuestion->expects($this->never())
            ->method('increaseCorrectAnswered');
        $nextQuestion->expects($this->never())
            ->method('increaseWrongAnswered');

        $this->answerRandomizer->method('randomizeAnswers')
            ->willReturnMap([
                [
                    $question,
                    [
                        'answers' => $questionArray['answers'],
                        'correctAnswerKey' => $questionArray['correctAnswer'],
                    ],
                ],
                [
                    $nextQuestion,
                    [
                        'answers' => $nextQuestionArray['answers'],
                        'correctAnswerKey' => $nextQuestionArray['correctAnswer'],
                    ],
                ],
            ]);

        $this->questionCollection->expects($this->exactly(2))
            ->method('getNext')
            ->willReturn($question, $nextQuestion);

        $this->output->expects($this->exactly(2))
            ->method('printQuestion')
            ->willReturnCallback(function(string $question) {
                $this->isOneOfQuestions($question);
            });
        $this->output->expects($this->exactly(2))
            ->method('printPossibleAnswers')
            ->willReturnCallback(function(array $possibleAnswers) {
                $this->isOneOfPossibleAnswerArrays($possibleAnswers);
            });
        $this->output->expects($this->once())
            ->method('printTotalResult')
            ->with([$question], []);
        $this->output->expects($this->once())
            ->method('printNotPossibleAnswer')
            ->with('not-possible-answer', $questionArray['answers']);


        $this->input->expects($this->exactly(3))
            ->method('getAnswer')
            ->willReturnOnConsecutiveCalls('not-possible-answer', $questionArray['correctAnswer'], 'exit');

        $this->examination->run($this->questionCollection);
    }

    public function testRunEndWithAllUsed(): void
    {
        $this->markTestIncomplete('This test has not been implemented.');
        // @TODO
    }

    /**
     * @param array<string, string> $toCheck
     */
    protected function isOneOfPossibleAnswerArrays(array $toCheck): void
    {
        foreach (static::QUESTIONS as $dataPack) {
            foreach ($dataPack as $question) {
                foreach ($question['answers'] as $key => $answer) {
                    if ($answer !== $toCheck[$key]) {
                        break;
                    }
                }

                return;
            }
        }

        $this->fail('Is not one of the possible answer lists');
    }

    protected function isOneOfQuestions(string $toCheck): void
    {
        foreach (static::QUESTIONS as $dataPack) {
            foreach ($dataPack as $question) {
                if ($question['question'] === $toCheck) {
                    return;
                }
            }
        }

        $this->fail(sprintf('`%s` is not one of the questions', $toCheck));
    }
}
