<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions;

class QuestionCollectionFactory
{
    public function create(): QuestionCollection
    {
        return new QuestionCollection();
    }
}
