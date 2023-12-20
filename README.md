# multiple-choice-question-console
A php script to load questions with answers from a file to create a multiple choice questions for the console.
With this project you can learn custom questions in your console.

## Input files
The files from where the questions are loaded.
Possible file types are currently json and xml.

### Json
The json file should look like this:
```json
{
  "questions": [
    {
      "questionText": "The question itself",
      "wrongAnswers": [
        "The first wrong answer",
        "The second wrong answer"
      ],
      "correctAnswer": "The correct answer"
    }
    {
      "questionText": "A question with only one wrong answer",
      "wrongAnswers": "The wrong answer",
      "correctAnswer": "The correct answer"
    }
  ]
}
```

### XML
The xml file should look like this:
```xml
<?xml version="1.0" encoding="utf-8" ?>

<questions xmlns="Questions">
    <questions>
        <questionText>The question itself</questionText>
        <wrongAnswers>The first wrong answer</wrongAnswers>
        <wrongAnswers>The second wrong answer</wrongAnswers>
        <correctAnswer>The correct answer</correctAnswer>
    </questions>
    <questions>
        <questionText>A question with only one wrong answer</questionText>
        <wrongAnswers>wrong answer 2</wrongAnswers>
        <correctAnswer>correct answer 2</correctAnswer>
    </questions>
</questions>
```

## Possible improvements
### More reputation algorithm
#### Less answered question
Question collection to always give back the question which was less often answered

#### Simple
Question collection to go always threw the collection without randomizing.

### Add Logging
Add correct logging instead of only echo

### Max Answers
A variable which defines how many answers should be printed max. The taken answers should be random but obviously with the correct one in it.

### Support more input file types
Support for more input file types besides json. For example xml, yml or plain txt.
