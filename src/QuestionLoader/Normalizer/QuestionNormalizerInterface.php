<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\Normalizer;

interface QuestionNormalizerInterface
{
    /**
     * @return array{
     *     questions: array<int, array{
     *          questionText: string,
     *          wrongAnswers: string|array<int, string>,
     *          rightAnswer: string
     *     }>
     * }
     */
    public function normalize(string $content): array;
}
