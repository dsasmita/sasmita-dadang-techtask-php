**Language :** English

# Description

Suggested recipes for lunch API

## Installation

- Clone this repository.

```bash
git clone git@github.com:dsasmita/sasmita-dadang-techtask-php.git
cd sasmita-dadang-techtask-php
```

- Run the setup command to setup the containers.

```bash
make setup
```

- Run init command to initialize the application. When done you will inside docker bash

```bash
make init
```

- after that can check [http://127.0.0.1:8080/lunch/?date=2019-03-07](http://127.0.0.1:8080/lunch/?date=2019-03-07)
  result for this will be

```json
{
  "date": "2019-03-07",
  "availableRecipes": [
    {
      "title": "Hotdog",
      "ingredients": ["Hotdog Bun", "Sausage", "Ketchup", "Mustard"],
      "bestBefore": "2019-03-25"
    },
    {
      "title": "Ham and Cheese Toastie",
      "ingredients": ["Ham", "Cheese", "Bread", "Butter"],
      "bestBefore": "2019-03-08"
    },
    {
      "title": "Salad",
      "ingredients": [
        "Lettuce",
        "Tomato",
        "Cucumber",
        "Beetroot",
        "Salad Dressing"
      ],
      "bestBefore": "2019-03-06"
    }
  ]
}
```

## Test and linter

### PHP unit

You can run the PHPUnit test using the command below.

```bash
make test
```

To run with coverage, use the command below.

```bash
make test-coverage
```

Open folder `coverage` in the application's root directory. and open with browser `coverage/index.html`.

### PHP Fixer

To check the coding standards issues using PHP Fixer, run the command below.

```bash
make check
```

To fix coding standards issues run the command below.

```bash
make lint
```

### PHP Stan

To check PHP Static Analysis Tool run the command below.

```bash
make phpstan
```

## Destroying container

```bash
make destroy
```
