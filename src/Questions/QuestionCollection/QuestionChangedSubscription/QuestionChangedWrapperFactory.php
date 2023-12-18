<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionChangedSubscription;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class QuestionChangedWrapperFactory
{
    public function create(QuestionInterface $question, QuestionChangeSubscriberInterface $subscriber): QuestionInterface
    {
        return new QuestionChangedWrapper($subscriber, $question);
    }
}
