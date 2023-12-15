<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow;

use Vogaeael\MultipleChoiceQuestionConsole\AnswerRandomizer;
use Vogaeael\MultipleChoiceQuestionConsole\Input\InputInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Output\OutputInterface;

class QuestionFlowFactory
{
    public function create(string $type, AnswerRandomizer $answerRandomizer, OutputInterface $output, InputInterface $input): QuestionFlowInterface
    {
        return match ($type) {
            'examination' => new Examination($answerRandomizer, $output, $input),
            default => new QuizCarousel($answerRandomizer, $output, $input),
        };
    }
}
