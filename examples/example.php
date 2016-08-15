<?php

namespace OtherCode\Examples;

require_once '../autoload.php';

require_once 'DummyOne.php';
require_once 'DummyTwo.php';

/**
 * First we get a controller instance,
 * then we register the modules into it.
 */
$ctrl = \OtherCode\FController\FController::getInstance();
$ctrl->setModule('dummy1', 'OtherCode\Examples\DummyOne');
$ctrl->setModule('dummy2', 'OtherCode\Examples\DummyTwo');

try {

    $data = array('name' => 'Rick');

    /**
     * execute two methods for each of them
     * from one different module.
     */
    $response1 = $ctrl->run("dummy1.sayHello", $data);
    $response2 = $ctrl->run("dummy2.sayGoodBye");

    /**
     * retrieve and dump all messages.
     */
    foreach ($ctrl->getMessages() as $message) {
        var_dump($message);
    }

    /**
     * dump the responses.
     */
    var_dump($response1, $response2);

} catch (\Exception $e) {

    /**
     * In case of any exception we control it
     */
    var_dump($e);
}