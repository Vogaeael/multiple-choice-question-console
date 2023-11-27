<?php

require 'vendor/autoload.php';

use Vogaeael\MultipleChoiceQuestionConsole\AnswerRandomizer;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollectionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader;
use Vogaeael\MultipleChoiceQuestionConsole\QuizCarousel;

$questionsLoader = new QuestionLoader(new QuestionCollectionFactory(), new QuestionFactory());
$answerRandomizer = new AnswerRandomizer();
$quizCarousel = new QuizCarousel($answerRandomizer);


// @TODO change
$path = 'var/shopware-advanced.json';
try {
    $questions = $questionsLoader->load($path);
    $quizCarousel->run($questions);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}