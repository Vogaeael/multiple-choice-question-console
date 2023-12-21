<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\FileLoader;


use Exception;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\ArrayToQuestionCollectionTransformer;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\Normalizer\QuestionNormalizerInterface;
use Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\QuestionLoaderInterface;
use Vogaeael\MultipleChoiceQuestionConsole\Questions\QuestionCollection\QuestionCollectionInterface;

class FileQuestionLoader implements QuestionLoaderInterface
{
    public function __construct(
        protected readonly FileContentLoader $fileContentLoader,
        protected readonly QuestionNormalizerInterface $normalizer,
        protected readonly ArrayToQuestionCollectionTransformer $transformer
    ) {}

    /**
     * @throws Exception
     */
    public function load(string $path, string $type): QuestionCollectionInterface
    {
        $content = $this->fileContentLoader->load($path);
        $questionsArray = $this->normalizer->normalize($content);

        return $this->transformer->transformToQuestionsCollection($questionsArray, $type);
    }
}
