# Pariksha
Pariksha is a question bank and testing web app for Computer Based Assessment (CBA), developed to cater the needs of educators, to felicitate and empower them by providing them with means to faster and accurate evaluations.

## Features
The web app allows education institutes to conduct examinations and streamline their assessment process. The features of Pariksha include:
* Providing registration for the examinations, examination centre, and student information.
* Generating random sets of questions from the database.
* Assessing responses and outputting scores automatically and immediately.
* Evaluating results of examinations with statistical analyses.

## Getting Started
### Prerequisites
The question-answer set should exist in the database before installation.

### Installing
1. Copy the contents of Pariksha repository into your webroot.
2. In the file [scripts/config.php](https://github.com/klbm9999/Pariksha/blob/master/scripts/config.php):
   * specify the details of the database, such as the username, password, and database name; and
   * specify the `no_of_questions` parameter.
3. Open the URL `http://your_webroot/quiz.php`.
