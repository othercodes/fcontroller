<?php

namespace OtherCode\Examples;

require_once "../autoload.php";

/**
 * Class Dummy
 */
class DummyOne extends \OtherCode\FController\Modules\BaseModule
{
    public function sayHello($name)
    {
        $this->storage->name = $name;
        $this->messages->addMessage('bla bla');
        var_dump($this->messages);
        return "Hello, " . $this->storage->name . "!";
    }
}

/**
 * Class Dummy
 */
class DummyTwo extends \OtherCode\FController\Modules\BaseModule
{
    public function sayGoodBye()
    {
        return "GoodBye, " . $this->storage->name . "!";
    }
}

/**
 * First we get a controller instance, the we
 * register the modules into it
 */
$ctrl = \OtherCode\FController\FController::getInstance();
$ctrl->setModule('dummy1', 'OtherCode\Examples\DummyOne');
$ctrl->setModule('dummy2', 'OtherCode\Examples\DummyTwo');

try {

    $data = array('name' => 'Rick');

    $response = $ctrl->run("dummy1.sayHello", $data);
    var_dump($response);

    $response = $ctrl->run("dummy2.sayGoodBye");
    var_dump($response);

} catch (\Exception $e) {

    var_dump($e);
}