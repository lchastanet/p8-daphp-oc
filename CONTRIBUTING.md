Contributing to p8-daphp-oc
--------------------------

This app is based on the Symfony framework, and so is written mostly in PHP.
Other languages used throughout are JavaScript, HTML, CSS and Twig templating languages.

To contribute to the project, you should ideally be familiar with Git.

Contributors should follow the following process:

## Creating an issue

If you have a problem, chances are high it is something very specific to your context, so don't hesitate to contact us and explain what's happened. Give as much information as you can. If you still think this is a problem or want to add a new feature, start by creating an issue. 

1. State clearly if it is a feature, a problem or refactoring.
2. Explain clearly in one/two sentences why that feature is important to you or why that problem causes you grief.
3. Wait until you receive a response to the created issue.

## Submitting a pull request 

After receiving a go to your issue, start working on your feature addition, bug fix or refactoring.

1. Create your GitHub account, if you do not have one already.
2. Fork the project to your Github account.
3. Clone your fork to your local machine.
4. Create a branch in your local clone for your changes.
5. Change the files in your branch. Be sure to follow [the coding standards](https://www.php-fig.org/).
6. Push your changed branch to your fork in your GitHub account.
7. Create a pull request for your changes on the project.
8. Wait for one of the core developers either to include your change in the codebase, or to comment on possible improvements you should make to your code.

## Running tests

Make sure that you don't break anything with your changes by running the test suite :

```bash
$ vendor/bin/phpunit
```