<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\WrongMoreOften\WrongMoreOften;

class QuestionCollectionFactory
{
    public const ALL_ONE_TIME = 'all_one_time';
    public const WRONG_MORE_OFTEN = 'wrong_more_often';
    public function create(string $type): QuestionCollectionInterface
    {
        return match ($type) {
            self::ALL_ONE_TIME => new AllOneTime(),
            self::WRONG_MORE_OFTEN => new WrongMoreOften(), // @TODO change
            default => new QuestionCollection(),
        };
    }
}
