<?php

namespace unit\Questions;

use PHPUnit\Framework\TestCase;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\Question;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionFactory;

class QuestionFactoryTest extends TestCase
{
    protected QuestionFactory $questionFactory;

    protected function setUp(): void
    {
        $this->questionFactory = new QuestionFactory();
    }

    public function testCreateWithoutHowOftenAnswered(): void
    {
        $questionText = 'This is the question?';
        $wrongAnswers = [
            'wrong answer a',
            'wrong answer b',
            'wrong answer c',
        ];
        $correctAnswer = 'correct answer';
        $actual = $this->questionFactory->create($questionText, $wrongAnswers, $correctAnswer);

        $this->assertInstanceOf(Question::class, $actual);

        $this->assertEquals($questionText, $actual->getQuestion());
        $this->assertEquals($wrongAnswers, $actual->getWrongAnswers());
        $this->assertEquals($correctAnswer, $actual->getCorrectAnswer());
        $this->assertEquals(0, $actual->getHowOftenWrongAnswered());
        $this->assertEquals(0, $actual->getHowOftenCorrectAnswered());
    }

    public function testCreateWithHowOftenAnswered(): void
    {
        $questionText = 'This is the question?';
        $wrongAnswers = [
            'wrong answer a',
            'wrong answer b',
            'wrong answer c',
        ];
        $correctAnswer = 'correct answer';
        $howOftenWrongAnswered = 3;
        $howOftenCorrectAnswered = 5;
        $actual = $this->questionFactory->create($questionText, $wrongAnswers, $correctAnswer, $howOftenWrongAnswered, $howOftenCorrectAnswered);

        $this->assertInstanceOf(Question::class, $actual);

        $this->assertEquals($questionText, $actual->getQuestion());
        $this->assertEquals($wrongAnswers, $actual->getWrongAnswers());
        $this->assertEquals($correctAnswer, $actual->getCorrectAnswer());
        $this->assertEquals($howOftenWrongAnswered, $actual->getHowOftenWrongAnswered());
        $this->assertEquals($howOftenCorrectAnswered, $actual->getHowOftenCorrectAnswered());
    }
}
