<?php

namespace unit\QuestionLoader\FileLoader;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\ArrayToQuestionCollectionTransformer;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileLoader\FileContentLoader;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileLoader\FileQuestionLoader;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\Normalizer\QuestionNormalizerInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionInterface;

class FileQuestionLoaderTest extends TestCase
{
    protected FileContentLoader & MockObject $fileContentLoader;
    protected QuestionNormalizerInterface & MockObject $normalizer;
    protected ArrayToQuestionCollectionTransformer & MockObject $transformer;
    protected QuestionCollectionInterface & MockObject $questionCollection;
    protected FileQuestionLoader $fileQuestionLoader;

    protected function setUp(): void
    {
        $this->fileContentLoader = $this->createMock(FileContentLoader::class);
        $this->normalizer = $this->createMock(QuestionNormalizerInterface::class);
        $this->transformer = $this->createMock(ArrayToQuestionCollectionTransformer::class);
        $this->questionCollection = $this->createMock(QuestionCollectionInterface::class);

        $this->fileQuestionLoader = new FileQuestionLoader($this->fileContentLoader, $this->normalizer, $this->transformer);
    }

    public function testLoad(): void
    {
        $pathToFile = 'path/to/file';
        $type = 'type';
        $contentOfFile = 'content of file';
        $questionsArray = [
            'questions' => [
                [
                    'questionText' => 'Is this question one?',
                    'wrongAnswers' => [
                        'wrong answer a.',
                        'wrong answer b.',
                    ],
                    'correctAnswer' => 'correct answer.',
                ],
                [
                    'questionText' => 'Is this question two?',
                    'wrongAnswers' => 'No!',
                    'correctAnswer' => 'Yes!',
                ],
            ],
        ];
        $this->fileContentLoader->method('load')
            ->with($pathToFile)
            ->willReturn($contentOfFile);
        $this->normalizer->method('normalize')
            ->with($contentOfFile)
            ->willReturn($questionsArray);
        $this->transformer->method('transformToQuestionsCollection')
            ->with($questionsArray, $type)
            ->willReturn($this->questionCollection);

        $actual = $this->fileQuestionLoader->load($pathToFile, $type);

        $this->assertSame($this->questionCollection, $actual);
    }
}
