<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

interface QuestionCollectionInterface
{


    public function add(QuestionInterface $question): void;

    public function getNext(): ?QuestionInterface;
}
