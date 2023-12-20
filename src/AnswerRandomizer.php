<?php

namespace Vogaeael\MultipleChoiceQuestionConsole;

use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class AnswerRandomizer
{
    /** @var array<int, string> $letterKeys */
    private array $alphabet;

    public function __construct()
    {
        $this->initAlphabet();
    }

    private function initAlphabet(): void
    {
        $this->alphabet = range('a', 'z');
    }

    /**
     * @return array{answers: array<string, string>, correctAnswerKey: string}
     * @throws Exception
     */
    public function randomizeAnswers(QuestionInterface $question): array
    {
        $wrongAnswers = $question->getWrongAnswers();
        $wrongAnswersCount = count($wrongAnswers);
        $positionRightAnswer = random_int(0, $wrongAnswersCount);
        shuffle($wrongAnswers);

        $answers = [];
        $currentKey = 0;
        $correctAnswerKey = '';
        foreach ($wrongAnswers as $wrongAnswer) {
            if ($currentKey === $positionRightAnswer) {
                $correctAnswerKey = $this->alphabet[$currentKey];
                $answers[$correctAnswerKey] = $question->getCorrectAnswer();
                $currentKey++;
            }
            $answers[$this->alphabet[$currentKey]] = $wrongAnswer;
            $currentKey++;
        }

        if (empty($correctAnswerKey)) {
            $correctAnswerKey = $this->alphabet[$currentKey];
            $answers[$correctAnswerKey] = $question->getCorrectAnswer();
        }

        return [
            'answers' => $answers,
            'correctAnswerKey' => $correctAnswerKey,
        ];
    }
}
