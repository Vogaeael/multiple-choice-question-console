<?php

namespace Vogaeael\MultipleChoiceQuestionConsole;

use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\Question;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection;

class QuizCarousel
{
    private const EXIT_KEY = 'exit';

    private AnswerRandomizer $answerRandomizer;
    private QuestionCollection $questions;

    public function __construct(
        AnswerRandomizer $answerRandomizer
    ) {
        $this->answerRandomizer = $answerRandomizer;
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
        $this->askQuestion($currentQuestion);
        $possibleAnswersWrapper = $this->answerRandomizer->randomizeAnswers($currentQuestion);
        $possibleAnswers = $possibleAnswersWrapper['answers'];
        $possibleAnswerKeys = array_keys($possibleAnswers);
        $this->printPossibleAnswers($possibleAnswers);
        do {
            $finishedQuestion = false;
            $answer = $this->getResponse('Your Answer: ');
            if ($answer === self::EXIT_KEY) {
                return true;
            }
            if (!in_array($answer, $possibleAnswerKeys)) {
                echo sprintf('`%s` is not one of the possible answers %s \n', $answer, implode(', ', $possibleAnswerKeys));
                continue;
            }
            $finishedQuestion = true;
            if ($answer === $possibleAnswersWrapper['rightAnswerKey']) {
                echo 'That is right!!' . PHP_EOL;
            }
            echo sprintf('That is wrong!! The correct answer would be %s', $possibleAnswersWrapper['rightAnswerKey']);
        } while(!$finishedQuestion);

        return false;
    }

    private function askQuestion(Question $question): void
    {
        echo $question->getQuestion() . PHP_EOL;
    }

    private function printPossibleAnswers(array $answers): void
    {
        foreach ($answers as $key => $answer) {
            echo sprintf('%s: %s', $key, $answer) . PHP_EOL;
        }
    }

    private function getResponse(string $message): string
    {
        return mb_strtolower(readline($message));
    }
}
