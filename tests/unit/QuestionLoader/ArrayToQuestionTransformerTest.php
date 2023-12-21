<?php

namespace unit\QuestionLoader;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\ArrayToQuestionTransformer;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\Question;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionFactory;

class ArrayToQuestionTransformerTest extends TestCase
{
    protected QuestionFactory & MockObject $factory;
    protected ArrayToQuestionTransformer $questionTransformer;

    protected function setUp(): void
    {
        $this->factory = $this->createMock(QuestionFactory::class);

        $this->questionTransformer = new ArrayToQuestionTransformer($this->factory);
    }

    public function testQuestionTextDoesNotExist(): void
    {
        $this->expectExceptionMessage('Array has not the key questionText');

        $this->questionTransformer->transform([
            'wrongAnswers' => [
                'wrong answer a.',
                'wrong answer b.',
            ],
            'correctAnswer' => 'correct answer.'
        ]);
    }

    public function testWrongAnswersDoesNotExist(): void
    {
        $this->expectExceptionMessage('Array has not the key wrongAnswers');

        $this->questionTransformer->transform([
            'questionText' => 'Is this question one?',
            'correctAnswer' => 'correct answer.'
        ]);
    }

    public function testCorrectAnswerDoesNotExist(): void
    {
        $this->expectExceptionMessage('Array has not the key correctAnswer');

        $this->questionTransformer->transform([
            'questionText' => 'Is this question one?',
            'wrongAnswers' => [
                'wrong answer a.',
                'wrong answer b.',
            ],
        ]);
    }

    public function testTransform(): void
    {
        $question = $this->createMock(Question::class);
        $this->factory->method('create')
            ->with('Is this question one?', ['wrong answer a.', 'wrong answer b.'], 'correct answer.')
            ->willReturn($question);

        $actual = $this->questionTransformer->transform([
            'questionText' => 'Is this question one?',
            'wrongAnswers' => [
                'wrong answer a.',
                'wrong answer b.',
            ],
            'correctAnswer' => 'correct answer.'
        ]);

        $this->assertSame($question, $actual);
    }

    public function testTransformWithOnlyOneWrongAnswer(): void
    {
        $question = $this->createMock(Question::class);
        $this->factory->method('create')
            ->with('Is this question one?', ['wrong answer a.'], 'correct answer.')
            ->willReturn($question);

        $actual = $this->questionTransformer->transform([
            'questionText' => 'Is this question one?',
            'wrongAnswers' => 'wrong answer a.',
            'correctAnswer' => 'correct answer.'
        ]);

        $this->assertSame($question, $actual);
    }
}
