<?php

namespace OtherCode\Examples;

require_once "../autoload.php";


class DummyOne extends \OtherCode\FController\Modules\BaseModule
{
    public function sayHello($name)
    {
        $this->storage->name = $name;
        $this->messages->addMessage('bla bla from dummy 1');
        return "Hello, " . $this->storage->name . "!";
    }
}

class DummyTwo extends \OtherCode\FController\Modules\BaseModule
{
    public function sayGoodBye()
    {
        $this->messages->addMessage('bla bla from dummy 2','warning');
        return "GoodBye, " . $this->storage->name . "!";
    }
}

class Calc
{
    public function sum($a, $b)
    {
        return $a + $b;
    }
}

/**
 * First we get a controller instance, the we
 * register the modules into it
 */
$ctrl = \OtherCode\FController\FController::getInstance();

$ctrl->setLibrary('calc', 'OtherCode\Examples\Calc');
$ctrl->setModule('dummy1', 'OtherCode\Examples\DummyOne');
$ctrl->setModule('dummy2', 'OtherCode\Examples\DummyTwo');

try {

    $data = array('name' => 'Rick');

    $response1 = $ctrl->run("dummy1.sayHello", $data);
    $response2 = $ctrl->run("dummy2.sayGoodBye");

    foreach ($ctrl->getMessages() as $message) {
        var_dump($message);
    }

    var_dump($response1, $response2);

} catch (\Exception $e) {

    var_dump($e);
}