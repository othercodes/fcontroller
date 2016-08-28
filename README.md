# FController

[![Build Status](https://travis-ci.org/othercodes/fcontroller.svg?branch=master)](https://travis-ci.org/othercodes/fcontroller) [![Latest Stable Version](https://poser.pugx.org/othercode/fcontroller/v/stable)](https://packagist.org/packages/othercode/fcontroller) [![License](https://poser.pugx.org/othercode/fcontroller/license)](https://packagist.org/packages/othercode/fcontroller)

FController is a container for controllers/modules. This package allow us to register several controllers/modules 
that can be called in a simply way from a common entry point. In the same way we can register multiple libraries 
or services. These services or libraries will be available in all modules. 

## Installation

### With Composer

First we have to add the dependencies to the ***composer.json*** file:

```javascrip
"require": {
    "othercode/fcontroller": "*",
}
```
Then we have to run the following command:

```bash
composer update
```

### Stand Alone

We need to download the package, then extract the content and include in your code the `fcontroller/autoload.php` file.

```php
require_once 'fcontroller/autoload.php';
```

## Basic Usage

First of all we must have the modules we want to the FController handle. For example we have this two dummy modules (classes):

```php
namespace OtherCode\Examples;

class DummyOne extends \OtherCode\FController\Modules\BaseModule
{
    public function sayHello($name)
    {
        $this->storage->name = $name;
        
        return "Hello, " . $name . "!";
    }
}
```

The DummyOne Module has one method `sayHello($name)` that accepts one string as parameter. This method return us a string.

```php
namespace OtherCode\Examples;

class DummyTwo extends \OtherCode\FController\Modules\BaseModule
{
    public function sayGoodBye()
    {
        return "GoodBye, " . $this->storage->name . "!";
    }
}
```

The DummyTwo Module has once again only one method named `sayGoodBye()`, this method also, return us a string.

Lets create a simply application that holds our two modules:

```php
namespace OtherCode\Examples;

require_once 'fcontroller/autoload.php';
require_once 'DummyOne.php';
require_once 'DummyTwo.php';

$app = \OtherCode\FController\FController::getInstance();
$app->setModule('dummy1', 'OtherCode\Examples\DummyOne');
$app->setModule('dummy2', 'OtherCode\Examples\DummyTwo');

try {

    $response1 = $app->run("dummy1.sayHello", array('name' => 'Rick'));
    $response2 = $app->run("dummy2.sayGoodBye");

    var_dump($response1, $response2);

} catch (\Exception $e) {

    var_dump($e);
}
```

The code above illustrate how we can call two different modules using one entry point. Also we can use 
services inside our modules. 

This package also has a message queue that can be used to display informative messages from our modules.

