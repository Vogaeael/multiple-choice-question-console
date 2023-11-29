<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Input;

interface InputInterface
{
    /**
     * Get the answer of the user
     */
    public function getAnswer(): string;
}
