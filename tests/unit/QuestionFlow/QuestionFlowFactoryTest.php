<?php

namespace unit\QuestionFlow;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Vogaeael\MultipleChoiceQuestionConsole\AnswerRandomizer;
use Vogaeael\MultipleChoiceQuestionConsole\Input\InputInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Output\OutputInterface;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow\Examination;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow\QuestionFlowFactory;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow\QuizCarousel;

class QuestionFlowFactoryTest extends TestCase
{
    protected QuestionFlowFactory $questionFlowFactory;
    protected AnswerRandomizer & MockObject $answerRandomizer;
    protected InputInterface & MockObject $input;
    protected OutputInterface & MockObject $output;

    protected function setUp(): void
    {
        $this->answerRandomizer = $this->createMock(AnswerRandomizer::class);
        $this->input = $this->createMock(InputInterface::class);
        $this->output = $this->createMock(OutputInterface::class);

        $this->questionFlowFactory = new QuestionFlowFactory();
    }

    public function testCreateExamination(): void
    {
        $this->abstractTestIfInstanceOfIsCreated(QuestionFlowFactory::EXAMINATION, Examination::class);
    }

    public function testCreateQuizCarousel(): void
    {
        $this->abstractTestIfInstanceOfIsCreated(QuestionFlowFactory::QUIZ_CAROUSEL, QuizCarousel::class);
    }

    public function testCreateDefault(): void
    {
        $this->abstractTestIfInstanceOfIsCreated('', QuizCarousel::class);
    }

    protected function abstractTestIfInstanceOfIsCreated(string $type, string $class): void
    {
        $actual = $this->questionFlowFactory->create(
            $type,
            $this->answerRandomizer,
            $this->output,
            $this->input
        );

        $this->assertInstanceOf($class, $actual);
    }
}
