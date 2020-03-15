# digitalRoot
Library for getting digital root from numbers and letters.

## Install

Via Composer

``` bash
$ composer require "anuar/digitalRoot"
```

## Usage examples

``` php
$digitalRoot = new \digitalRootSrc\digitalRootBuilder();

$digitalRoot->getdigitalRootFullResult($my_input);
$digitalRoot->getdigitalRootFinalResult($my_input);
$digitalRoot->getdigitalRootBulkResult($my_input_array);