# vortexmath
Library for vortex based math functions.


## Install

Via Composer

``` bash
$ composer require "anuar/vortexmath"
```

## Usage examples

``` php
$xdg = new \XdgBaseDir\Xdg();

$vortex = new \VortexMathSrc\VortexBuilder();

$vortex->getVortexFullResult($my_input);
$vortex->getVortexFinalResult($my_input);
$vortex->getVortexBulkResult($my_input_array);