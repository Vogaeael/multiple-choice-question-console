<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Input;

class ConsoleInput implements InputInterface
{

    /**
     * @inheritDoc
     */
    public function getAnswer(): string
    {
        return mb_strtolower(readline('Your Answer: '));
    }
}
