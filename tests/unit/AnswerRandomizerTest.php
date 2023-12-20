<?php

namespace unit;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Vogaeael\MultipleChoiceQuestionConsole\AnswerRandomizer;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class AnswerRandomizerTest extends TestCase
{
    protected const WRONG_ANSWERS = [
        'wrong answer one.',
        'wrong answer two.',
        'wrong answer three.',
    ];
    protected const CORRECT_ANSWER = 'correct answer.';

    protected QuestionInterface $question;
    protected AnswerRandomizer $answerRandomizer;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->question = $this->createMock(QuestionInterface::class);
        $this->question->method('getWrongAnswers')
            ->willReturn(static::WRONG_ANSWERS);
        $this->question->method('getCorrectAnswer')
            ->willReturn(static::CORRECT_ANSWER);

        $this->answerRandomizer = new AnswerRandomizer();
    }

    public function testIfEveryTimeHasAllAnswersInRandomizeAnswers(): void
    {
        $expectedNumberAnswers = 4;
        for ($i = 0; $i < 10; $i++) {
            $answerWrapper = $this->answerRandomizer->randomizeAnswers($this->question);

            $this->assertCount($expectedNumberAnswers, $answerWrapper['answers']);
            $this->assertContains(static::CORRECT_ANSWER, $answerWrapper['answers']);
            foreach (static::WRONG_ANSWERS as $wrongAnswer) {
                $this->assertContains($wrongAnswer, $answerWrapper['answers']);
            }
        }
    }

    public function testIfEveryTimeAnswerKeyPointsToCorrectAnswerInRandomizeAnswers(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $answerWrapper = $this->answerRandomizer->randomizeAnswers($this->question);

            $this->assertEquals(static::CORRECT_ANSWER, $answerWrapper['answers'][$answerWrapper['correctAnswerKey']]);
        }
    }

    public function testIfCorrectAnswerCanBeInEveryPositionInRandomizeAnswers(): void
    {
        $hadPosition = [];

        $countHadPositionShouldBe = count(static::WRONG_ANSWERS) + 1;
        $i = 0;
        while($countHadPositionShouldBe > count($hadPosition)) {
            $answerWrapper = $this->answerRandomizer->randomizeAnswers($this->question);
            $hadPosition[] = $answerWrapper['correctAnswerKey'];

            $hadPosition = array_unique($hadPosition);
            $i++;

            if ($i > 1000) {
                $message = sprintf('The Correct answer only had the positions: %s.', implode('. ', $hadPosition));
                $this->fail($message);
            }
        }

        $this->assertContains('a', $hadPosition);
        $this->assertContains('b', $hadPosition);
        $this->assertContains('c', $hadPosition);
        $this->assertContains('d', $hadPosition);
    }

    public function testIfWrongAnswersAreRandomOrderedInRandomizeAnswers(): void
    {
        $wrongAnswersHadPosition = [];
        $i = 0;
        while (!$this->hadEveryWrongAnswerEveryPosition($wrongAnswersHadPosition)) {
            $answerWrapper = $this->answerRandomizer->randomizeAnswers($this->question);
            foreach ($answerWrapper['answers'] as $key => $answer) {
                if (in_array($answer, static::WRONG_ANSWERS)) {
                    $wrongAnswersHadPosition[$answer][] = $key;
                    $wrongAnswersHadPosition[$answer] = array_unique($wrongAnswersHadPosition[$answer]);
                }
            }
            $i++;

            if ($i > 1000) {
                $wrongAnswersPositionMessages = [];
                foreach ($wrongAnswersHadPosition as $wrongAnswer => $hadPositions) {
                    $wrongAnswersPositionMessages[] = sprintf('Answer `%s` was in positions %s.', $wrongAnswer, implode(', ', $hadPositions));
                }
                $message = sprintf('Not all wrong answers were in all position. %s', implode(' ', $wrongAnswersPositionMessages));
                $this->fail($message);
            }
        }

        foreach ($wrongAnswersHadPosition as $positions) {
            $this->assertContains('a', $positions);
            $this->assertContains('b', $positions);
            $this->assertContains('c', $positions);
            $this->assertContains('d', $positions);
        }
    }

    /**
     * @param array<string, string[]> $wrongAnswersHadPosition
     */
    protected function hadEveryWrongAnswerEveryPosition(array $wrongAnswersHadPosition): bool
    {
        foreach (static::WRONG_ANSWERS as $wrongAnswer) {
            if (!array_key_exists($wrongAnswer, $wrongAnswersHadPosition)) {
                return false;
            }
            $answerHadPositions = $wrongAnswersHadPosition[$wrongAnswer];
            if (count(static::WRONG_ANSWERS) + 1 > count(array_unique($answerHadPositions))) {
                return false;
            }
        }

        return true;
    }
}
