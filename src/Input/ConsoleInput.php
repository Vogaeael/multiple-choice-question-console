<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Input;

use Vogaeael\MultipleChoiceQuestionConsole\Input\InputInterface;

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
