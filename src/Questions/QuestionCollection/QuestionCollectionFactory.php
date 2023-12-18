<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionChangedSubscription\QuestionChangedWrapperFactory;

class QuestionCollectionFactory
{
    public const ALL_ONE_TIME = 'all_one_time';
    public const WRONG_MORE_OFTEN = 'wrong_more_often';
    public const RARE_MORE_OFTEN = 'rare_more_often';
    public const SIMPLE_RANDOM = 'simple_random';

    public function create(string $type): QuestionCollectionInterface
    {
        return match ($type) {
            self::ALL_ONE_TIME => new AllOneTime(),
            self::WRONG_MORE_OFTEN => new WrongMoreOften(new QuestionChangedWrapperFactory()),
            self::RARE_MORE_OFTEN => new RareQuestionMoreOften(new QuestionChangedWrapperFactory()),
            default => new SimpleRandomQuestionCollection(),
        };
    }
}
