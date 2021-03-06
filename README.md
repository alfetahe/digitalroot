# digitalRoot
Library for getting digital root from numbers and letters. 
You may also give letters numeric value for the calculation by passing an array
of letters and their numeric values as a second parameter to the exposed functions.
All examples and methods are shown below.

The digital root of a positive integer is found by summing the digits of the integer. If the resulting value is a single digit then that digit is the digital root. If the resulting value contains two or more digits, those digits are summed and the process is repeated. This is continued as long as necessary to obtain a single digit.

I am going to add additional functionality to this library in the future. Open to any new ideas.
## Install

Via Composer

``` bash
$ composer require "anuar/digitalroot"
```

## Usage examples

``` php
use \digitalRootSrc\digitalRootBuilder;

// Returns the digital root(single digit).
// Output: [
//            "client_input" => "23081996",
//            "digital_root" => 2
//         ]
digitalRootBuilder::getDigitalRoot("23081996");


// Returns the digital root complete calculation.
// Output: [
//            "client_input" => "299493218",
//            "digital_root" => 2,
//            "full_calculation" => [2,9,11,1,1,2,9,11,1,1,2,4,6,9,15,1,5,6,3,9,2,11,1,1,2,1,3,8,11,1,1,2]
digitalRootBuilder::getDigitalRootCompleteCalculation("299493218");


// Pass array and returns array of digital roots.
// Output: [
//           "23081996' => 2,
//           "43434336" => 3
//         ]
digitalRootBuilder::getdigitalRootBulk(["23081996","43434336"]);


// You can also give letters numeric value and get their digital root.
// Then you need to pass second parameter which gives each letter numeric value.
// Output: [
//            'client_input' => "abc12",
//            'digital_root' => 9
//         ]
digitalRootBuilder::getDigitalRoot("abc12", ["A" => 1, "B" => 2, "C" => 3]);
