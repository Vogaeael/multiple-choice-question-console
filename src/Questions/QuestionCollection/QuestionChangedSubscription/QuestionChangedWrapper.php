<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionChangedSubscription;

use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionInterface;

class QuestionChangedWrapper implements QuestionInterface
{

    public function __construct(
        protected QuestionChangeSubscriberInterface $subscriber,
        protected QuestionInterface $question
    ) {}

    /**
     * @inheritDoc
     */
    public function getQuestion(): string
    {
        return $this->question->getQuestion();
    }

    /**
     * @inheritDoc
     */
    public function getWrongAnswers(): array
    {
        return $this->question->getWrongAnswers();
    }

    /**
     * @inheritDoc
     */
    public function getCorrectAnswer(): string
    {
        return $this->question->getCorrectAnswer();
    }

    public function increaseWrongAnswered(): void
    {
        $this->question->increaseWrongAnswered();
        $this->subscriber->changed($this);
    }

    public function increaseCorrectAnswered(): void
    {
        $this->question->increaseCorrectAnswered();
        $this->subscriber->changed($this);
    }

    public function getHowOftenCorrectAnswered(): int
    {
        return $this->question->getHowOftenCorrectAnswered();
    }

    public function getHowOftenWrongAnswered(): int
    {
        return $this->question->getHowOftenWrongAnswered();
    }

    public function howOftenAnswered(): int
    {
        return $this->question->howOftenAnswered();
    }
}
