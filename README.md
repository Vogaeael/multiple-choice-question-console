# multiple-choice-question-console
A php script to load questions with answers from a file to create a multiple choice questions for the console.
With this project you can learn custom questions in your console.

## Env file
To use this you have to copy the .env.example into an .env file.
You have to configure the environment variables.

### INPUT_FILE_PATH
The `INPUT_FILE_PATH` gives the path to the file with the questions configured. This can look like this
```
INPUT_FILE_PATH=var/questions.json
```

### INPUT_FILE_TYPE
The `INPUT_FILE_TYPE` defines which type of content the file has. The possible contents are at the moment json and xml.
So it can look like this:
```
INPUT_FILE_TYPE=json
```

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

### XML
The xml file should look like this:
```xml
<?xml version="1.0" encoding="utf-8" ?>

<questions xmlns="Questions">
    <questions>
        <questionText>The question itself</questionText>
        <wrongAnswers>The first wrong answer</wrongAnswers>
        <wrongAnswers>The second wrong answer</wrongAnswers>
        <rightAnswer>The right answer</rightAnswer>
    </questions>
    <questions>
        <questionText>A question with only one wrong answer</questionText>
        <wrongAnswers>wrong answer 2</wrongAnswers>
        <rightAnswer>right answer 2</rightAnswer>
    </questions>
</questions>
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
