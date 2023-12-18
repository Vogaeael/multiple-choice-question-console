<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionChangedSubscription;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

interface QuestionChangeSubscriberInterface
{
    public function changed(QuestionInterface $question): void;
}
