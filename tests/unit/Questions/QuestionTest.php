<?php

namespace unit\Questions;

use PHPUnit\Framework\TestCase;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\Question;

class QuestionTest extends TestCase
{
    protected const QUESTION_TEXT = 'Is this the question?';
    protected const WRONG_ANSWERS = [
        'wrong answer one.',
        'wrong answer two.',
        'wrong answer three.',
    ];
    protected const CORRECT_ANSWER = 'correct answer.';

    protected Question $question;

    protected function setUp(): void
    {
        $this->question = new Question(static::QUESTION_TEXT, static::WRONG_ANSWERS, static::CORRECT_ANSWER);
    }

    public function testGetValues(): void
    {
        $this->assertEquals(static::QUESTION_TEXT, $this->question->getQuestion());
        $this->assertEquals(static::WRONG_ANSWERS, $this->question->getWrongAnswers());
        $this->assertEquals(static::CORRECT_ANSWER, $this->question->getCorrectAnswer());
        $this->assertEquals(0, $this->question->getHowOftenWrongAnswered());
        $this->assertEquals(0, $this->question->getHowOftenCorrectAnswered());
    }

    public function testIncreaseHowOftenAnswered(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->question->increaseWrongAnswered();
        }

        for ($i = 0; $i < 7; $i++) {
            $this->question->increaseCorrectAnswered();
        }

        $this->assertEquals(3, $this->question->getHowOftenWrongAnswered());
        $this->assertEquals(7, $this->question->getHowOftenCorrectAnswered());
    }

    public function testTotalHowOftenAnswered(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $this->question->increaseWrongAnswered();
        }

        for ($i = 0; $i < 3; $i++) {
            $this->question->increaseCorrectAnswered();
        }

        $this->assertEquals(9, $this->question->howOftenAnswered());
    }
}
