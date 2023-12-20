<?php

namespace unit\QuestionLoader\Normalizer;

use PHPUnit\Framework\TestCase;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\Normalizer\JsonQuestionNormalizer;

class JsonQuestionNormalizerTest extends TestCase
{
    protected const JSON_INPUT = '{"questions":[{"questionText":"Is this question one?","wrongAnswers":["wrong answer a.","wrong answer b.","wrong answer c."],"correctAnswer":"correct answer one."},{"questionText":"Is this question two?","wrongAnswers":["wrong answer d."],"correctAnswer":"correct answer two."}]}';
    protected const EXPECTED = [
        'questions' => [
            [
                'questionText' => 'Is this question one?',
                'wrongAnswers' => [
                    'wrong answer a.',
                    'wrong answer b.',
                    'wrong answer c.',
                ],
                'correctAnswer' => 'correct answer one.',
            ],
            [
                'questionText' => 'Is this question two?',
                'wrongAnswers' => [ 'wrong answer d.' ],
                'correctAnswer' => 'correct answer two.',
            ],
        ],
    ];

    protected JsonQuestionNormalizer $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new JsonQuestionNormalizer();
    }

    public function testNormalize(): void
    {
        $actual = $this->normalizer->normalize(static::JSON_INPUT);

        $this->assertEquals(static::EXPECTED, $actual);
    }
}
