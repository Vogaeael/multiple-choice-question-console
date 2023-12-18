<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow;

use Vogaeael\MultipleChoiceQuestionConsole\AnswerRandomizer;
use Vogaeael\MultipleChoiceQuestionConsole\Input\InputInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Output\OutputInterface;

class QuestionFlowFactory
{
    public const EXAMINATION = 'examination';
    public const QUIZ_CAROUSEL = 'quiz-carousel';

    public function create(string $type, AnswerRandomizer $answerRandomizer, OutputInterface $output, InputInterface $input): QuestionFlowInterface
    {
        return match ($type) {
            static::EXAMINATION => new Examination($answerRandomizer, $output, $input),
            default => new QuizCarousel($answerRandomizer, $output, $input),
        };
    }
}
