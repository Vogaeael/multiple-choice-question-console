<?php

namespace Vogaeael\MultipleChoiceQuestionConsole;

use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\Question;

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
     * @return array{answers: array<string, string>, rightAnswerKey: string}
     * @throws Exception
     */
    public function randomizeAnswers(Question $question): array
    {
        $wrongAnswers = $question->getWrongAnswers();
        $wrongAnswersCount = count($wrongAnswers);
        $positionRightAnswer = random_int(0, $wrongAnswersCount);
        shuffle($wrongAnswers);

        $answers = [];
        $currentKey = 0;
        $rightAnswerKey = '';
        foreach ($wrongAnswers as $wrongAnswer) {
            if ($currentKey === $positionRightAnswer) {
                $rightAnswerKey = $this->alphabet[$currentKey];
                $answers[$rightAnswerKey] = $question->getRightAnswer();
                $currentKey++;
            }
            $answers[$this->alphabet[$currentKey]] = $wrongAnswer;
            $currentKey++;
        }

        if (empty($rightAnswerKey)) {
            $rightAnswerKey = $this->alphabet[$currentKey];
            $answers[$rightAnswerKey] = $question->getRightAnswer();
        }

        return [
            'answers' => $answers,
            'rightAnswerKey' => $rightAnswerKey,
        ];
    }
}
