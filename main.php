<?php

require 'vendor/autoload.php';

use Vogaeael\MultipleChoiceQuestionConsole\AnswerRandomizer;
use Vogaeael\MultipleChoiceQuestionConsole\Input\ConsoleInput;
use Vogaeael\MultipleChoiceQuestionConsole\Output\ConsoleOutput;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileQuestionLoader;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\Normalizer\JsonQuestionNormalizer;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollectionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\QuizCarousel;

$env = parse_ini_file('.env');
if (!$env) {
    exit('No .env file found' . PHP_EOL);
}
if (empty($env)) {
    exit('env is empty' . PHP_EOL);
}
$path = $env

$jsonFileQuestionsLoader = new FileQuestionLoader(new QuestionCollectionFactory(), new QuestionFactory(), new JsonQuestionNormalizer());
$consoleOutput = new ConsoleOutput();
$quizCarousel = new QuizCarousel(new AnswerRandomizer(), $consoleOutput, new ConsoleInput());

try {
    $questions = $jsonFileQuestionsLoader->load($path);
    $quizCarousel->run($questions);
} catch (Exception $e) {
    $consoleOutput->error($e->getMessage());
}
