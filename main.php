<?php

require 'vendor/autoload.php';

use Vogaeael\MultipleChoiceQuestionConsole\AnswerRandomizer;
use Vogaeael\MultipleChoiceQuestionConsole\Input\ConsoleInput;
use Vogaeael\MultipleChoiceQuestionConsole\Output\ConsoleOutput;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionFlow\QuestionFlowFactory;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileQuestionLoader;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\Normalizer\JsonQuestionNormalizer;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionFactory;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionFactory;

$jsonFileQuestionsLoader = new FileQuestionLoader(new QuestionCollectionFactory(), new QuestionFactory(), new JsonQuestionNormalizer());
$consoleOutput = new ConsoleOutput();
$answerRandomizer = new AnswerRandomizer();
$input = new ConsoleInput();
$questionFlowFactory = new QuestionFlowFactory();

$questionFlow = $questionFlowFactory->create(QuestionFlowFactory::QUIZ_CAROUSEL, $answerRandomizer, $consoleOutput, $input);

// @TODO change
$path = 'var/shopware-advanced.json';
try {
    // @TODO add correct type
    $questions = $jsonFileQuestionsLoader->load($path, QuestionCollectionFactory::WRONG_MORE_OFTEN);
    $questionFlow->run($questions);
} catch (Exception $e) {
    $consoleOutput->error($e->getMessage());
}
