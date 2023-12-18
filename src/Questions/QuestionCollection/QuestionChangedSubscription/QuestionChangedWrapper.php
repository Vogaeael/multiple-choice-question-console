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
    public function getRightAnswer(): string
    {
        return $this->question->getRightAnswer();
    }

    public function increaseWrongAnswered(): void
    {
        $this->question->increaseWrongAnswered();
        $this->subscriber->changed($this);
    }

    public function increaseRightAnswered(): void
    {
        $this->question->increaseRightAnswered();
        $this->subscriber->changed($this);
    }

    public function getHowOftenRightAnswered(): int
    {
        return $this->question->getHowOftenRightAnswered();
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
