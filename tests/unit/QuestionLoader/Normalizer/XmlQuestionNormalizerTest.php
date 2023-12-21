<?php

namespace unit\QuestionLoader\Normalizer;

use PHPUnit\Framework\TestCase;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\Normalizer\XmlQuestionNormalizer;

class XmlQuestionNormalizerTest extends TestCase
{
    protected const JSON_INPUT = '<?xml version="1.0" encoding="utf-8" ?><questions><questions><questionText>Is this question one?</questionText><wrongAnswers>wrong answer a.</wrongAnswers><wrongAnswers>wrong answer b.</wrongAnswers><wrongAnswers>wrong answer c.</wrongAnswers><correctAnswer>correct answer one.</correctAnswer></questions><questions><questionText>Is this question two?</questionText><wrongAnswers>wrong answer d.</wrongAnswers><correctAnswer>correct answer two.</correctAnswer></questions></questions>';
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
                'wrongAnswers' => 'wrong answer d.',
                'correctAnswer' => 'correct answer two.',
            ],
        ],
    ];

    protected XmlQuestionNormalizer $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new XmlQuestionNormalizer();
    }

    public function testNormalize(): void
    {
        $actual = $this->normalizer->normalize(static::JSON_INPUT);

        $this->assertEquals(static::EXPECTED, $actual);
    }
}
