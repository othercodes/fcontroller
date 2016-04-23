<?php

namespace OtherCode\Examples;

require_once "../autoload.php";

/**
 * Class Dummy
 */
class Dummy extends \OtherCode\FController\Modules\BaseModule
{
    public function sayHello($name)
    {
        return "Hello, " . $name . "!";
    }

    public function sayGoodBye($name)
    {
        return "GoodBye, " . $name . "!";
    }
}

/**
 * First we get a controller instance, the we
 * register the modules into it
 */
$ctrl = \OtherCode\FController\FController::getInstance();
$ctrl->setModule('dummy', 'OtherCode\Examples\Dummy');

try {

    $data = array('name' => 'Rick');

    $response = $ctrl->run("dummy.sayHello", $data);
    var_dump($response);

    $response = $ctrl->run("dummy.sayGoodBye", $data);
    var_dump($response);

} catch (\Exception $e) {

    var_dump($e);
}