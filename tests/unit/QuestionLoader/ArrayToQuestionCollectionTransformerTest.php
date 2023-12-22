<?php

namespace unit\QuestionLoader;

use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Vogaeael\MultipleChoiceQuestionConsole\Output\OutputInterface;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\ArrayToQuestionCollectionTransformer;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\ArrayToQuestionTransformer;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\Question;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class ArrayToQuestionCollectionTransformerTest extends TestCase
{
    protected QuestionCollectionFactory & MockObject $collectionFactory;
    protected ArrayToQuestionTransformer & MockObject $questionTransformer;
    protected OutputInterface & MockObject $output;
    protected QuestionCollectionInterface & MockObject $questionCollection;
    protected Question & MockObject $questionOne;
    protected Question & MockObject $questionThree;
    protected ArrayToQuestionCollectionTransformer $questionCollectionTransformer;
    protected Exception $exception;

    protected function setUp(): void
    {
        $this->collectionFactory = $this->createMock(QuestionCollectionFactory::class);
        $this->questionTransformer = $this->createMock(ArrayToQuestionTransformer::class);
        $this->output = $this->createMock(OutputInterface::class);
        $this->questionCollection = $this->createMock(QuestionCollectionInterface::class);

        $this->questionCollectionTransformer = new ArrayToQuestionCollectionTransformer($this->collectionFactory, $this->questionTransformer, $this->output);
    }

    public function testNoQuestions(): void
    {
        $this->expectExceptionMessage('input file has not entry `questions`');

        $this->questionCollectionTransformer->transformToQuestionsCollection([], 'type');
    }

    public function testTransform(): void
    {
        $questionArray = [
            'questions' => [
                [
                    'questionText' => 'Is this question one?',
                    'wrongAnswers' => [
                        'wrong answer a.',
                        'wrong answer b.',
                        'wrong answer c.',
                    ],
                    'correctAnswer' => 'correct answer.',
                ],
                [
                    'questionText' => 'Is this question two?',
                    'wrongAnswers' => [
                    ],
                    'correctAnswer' => 'correct answer.',
                ],
                [
                    'questionText' => 'Is this question three?',
                    'wrongAnswers' => [
                        'wrong answer d.',
                        'wrong answer e.',
                        'wrong answer f.',
                    ],
                    'correctAnswer' => 'correct answer.',
                ],
            ],
        ];

        $this->questionOne = $this->createMock(Question::class);
        $this->questionThree = $this->createMock(Question::class);
        $this->exception = new Exception('A question must have minimal one wrong answer.');

        $this->collectionFactory->method('create')
            ->with('type')
            ->willReturn($this->questionCollection);

        $this->questionTransformer->expects($this->exactly(3))
            ->method('transform')
            ->willReturnCallback(function (array $questionArray) {
                switch ($questionArray['questionText']) {
                    case 'Is this question one?': return $this->questionOne;
                    case 'Is this question two?': throw $this->exception;
                    case 'Is this question three?': return $this->questionThree;
                    default: $this->fail('Not possible transform input');
                }
            });

        $this->questionCollection->expects($this->exactly(2))
            ->method('add')
            ->willReturnCallback(function (QuestionInterface $question) {
                switch ($question) {
                    case $this->questionOne:
                    case $this->questionThree:
                        break;
                    default: $this->fail('Should not add another question to question-collection');
                }
            });

        $this->output->expects($this->once())
            ->method('error')
            ->with($this->exception);

        $actual = $this->questionCollectionTransformer->transformToQuestionsCollection($questionArray, 'type');

        $this->assertSame($this->questionCollection, $actual);
    }
}
