# multiple-choice-question-console
A php script to load questions with answers from a file to create a multiple choice questions for the console.
With this project you can learn custom questions in your console.

## Input files
The files from where the questions are loaded.
Possible file types are currently json.

### Json
The json file should look like this.
```json
{
  "questions": [
    {
      "questionText": "The question itself",
      "wrongAnswers": [
        "The first wrong answer",
        "The second wrong answer"
      ],
      "rightAnswer": "The right answer"
    }
    {
      "questionText": "A question with only one wrong answer",
      "wrongAnswers": "The wrong answer",
      "rightAnswer": "The right answer"
    }
  ]
}
```

## Possible improvements
### More often Failures
An algorithm to more often bring up wrong answered questions.

### Add Logging
Add correct logging instead of only echo

### Max Answers
A variable which defines how many answers should be printed max. The taken answers should be random but obviously with the right one in it.

### Support more input file types
Support for more input file types besides json. For example xml, yml or plain txt.
