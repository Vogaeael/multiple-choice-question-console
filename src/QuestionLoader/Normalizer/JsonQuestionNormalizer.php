<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\Normalizer;

class JsonQuestionNormalizer implements QuestionNormalizerInterface
{
    /**
     * @inheritDoc
     */
    public function normalize(string $content): array
    {
        return json_decode($content, true);
    }
}
