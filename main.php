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

$jsonFileQuestionsLoader = new FileQuestionLoader(new QuestionCollectionFactory(), new QuestionFactory(), new JsonQuestionNormalizer());
$consoleOutput = new ConsoleOutput();
$quizCarousel = new QuizCarousel(new AnswerRandomizer(), $consoleOutput, new ConsoleInput());


// @TODO change
$path = 'var/shopware-advanced.json';
try {
    $questions = $jsonFileQuestionsLoader->load($path);
    $quizCarousel->run($questions);
} catch (Exception $e) {
    $consoleOutput->error($e->getMessage());
}
