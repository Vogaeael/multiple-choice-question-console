<?php

require 'vendor/autoload.php';

use Vogaeael\MultipleChoiceQuestionConsole\AnswerRandomizer;
use Vogaeael\MultipleChoiceQuestionConsole\Input\ConsoleInput;
use Vogaeael\MultipleChoiceQuestionConsole\Output\ConsoleOutput;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\JsonFileQuestionLoader;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollectionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\QuizCarousel;

$jsonFileQuestionsLoader = new JsonFileQuestionLoader(new QuestionCollectionFactory(), new QuestionFactory());
$answerRandomizer = new AnswerRandomizer();
$consoleOutput = new ConsoleOutput();
$consoleInput = new ConsoleInput();
$quizCarousel = new QuizCarousel($answerRandomizer, $consoleOutput, $consoleInput);


// @TODO change
$path = 'var/shopware-advanced.json';
try {
    $questions = $jsonFileQuestionsLoader->load($path);
    $quizCarousel->run($questions);
} catch (Exception $e) {
    $consoleOutput->error($e->getMessage());
}
