<?php

namespace Vogaeael\MultipleChoiceQuestionConsole\QuestionLoader\Normalizer;

class XmlQuestionNormalizer implements QuestionNormalizerInterface
{
    /**
     * @inheritDoc
     */
    public function normalize(string $content): array
    {
        $xml = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);

        return json_decode($json, true);
    }
}
