<?php

namespace Vogaeael\MultipleChoiceQuestionConsole;

use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\Input\InputInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Output\OutputInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\Question;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;

class QuizCarousel
{
    private const EXIT_KEY = 'exit';

    private AnswerRandomizer $answerRandomizer;
    private OutputInterface $output;
    private InputInterface $input;
    private QuestionCollection $questions;

    public function __construct(
        AnswerRandomizer $answerRandomizer,
        OutputInterface $output,
        InputInterface $input
    ) {
        $this->answerRandomizer = $answerRandomizer;
        $this->output = $output;
        $this->input = $input;
    }

    /**
     * @throws Exception
     */
    public function run(QuestionCollection $questions): void
    {
        $this->questions = $questions;
        do {
            $exit = $this->doCurrentQuestion();
        } while(!$exit);
    }

    /**
     * @return bool, true if it was 'exit'
     * @throws Exception
     */
    private function doCurrentQuestion(): bool
    {
        $currentQuestion = $this->questions->getRandom();
        $this->output->printQuestion($currentQuestion->getQuestion());
        $possibleAnswersWrapper = $this->answerRandomizer->randomizeAnswers($currentQuestion);
        $possibleAnswers = $possibleAnswersWrapper['answers'];
        $possibleAnswerKeys = array_keys($possibleAnswers);
        $this->output->printPossibleAnswers($possibleAnswers);
        do {
            $finishedQuestion = false;
            $answer = $this->input->getAnswer();
            if ($answer === self::EXIT_KEY) {
                return true;
            }
            if (!in_array($answer, $possibleAnswerKeys)) {
                $this->output->printNotPossibleAnswer($answer, $possibleAnswers);
                continue;
            }
            $finishedQuestion = true;
            $rightAnswerKey = $possibleAnswersWrapper['rightAnswerKey'];
            if ($answer === $rightAnswerKey) {
                $this->output->printIsCorrectAnswer();
                continue;
            }
            $this->output->printIsWrongAnswer($rightAnswerKey, $possibleAnswers[$rightAnswerKey]);
        } while(!$finishedQuestion);

        return false;
    }
}
