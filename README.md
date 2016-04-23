# FController

[![Build Status](https://travis-ci.org/othercodes/fcontroller.svg?branch=master)](https://travis-ci.org/othercodes/fcontroller) [![Latest Stable Version](https://poser.pugx.org/othercode/fcontroller/v/stable)](https://packagist.org/packages/othercode/fcontroller) [![License](https://poser.pugx.org/othercode/fcontroller/license)](https://packagist.org/packages/othercode/fcontroller)

Advanced front controller and registry that allow us to use several modules with only one entry point or interface. 

## Installation

First we have to add the dependencies to the ***composer.json*** file:

```
"require": {
    "othercode/fcontroller": "*",
}
```
Then we have to run the following command:

```
composer update
```

## Basic Usage

First of all we must have the modules we want to the FController handle. For example we have this two dummy modules (classes):

#### DummyOne
```
class DummyOne
{

	public function __construct()
	{
		//do something
	}

	public function sayHello($name = "World")
	{
		return "Hello, ".$name."!";
	}

	public function sayGoodBye($name = "World")
	{
		return "GoodBye, ".$name."!";
	}

}
```

#### DummyTwo
```
use DateTime;

class DummyTwo
{

	public function __construct()
	{
		//do something
	}

	public function whatTimeIsIt()
	{
		$now = new DateTime("now");
		return $now->format("H:i:s");
	}
	
	public function whatDayIsIt()
	{
		$today = new DateTime("now");
        return $today->format("Y-m-d");
	}

}
```

