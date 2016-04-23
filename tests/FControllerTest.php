<?php

namespace OtherCode\Test;

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


class FControllerTest extends \PHPUnit_Framework_TestCase
{

    public function testInstantiation()
    {
        $ctrl = \OtherCode\FController\FController::getInstance();
        $this->assertInstanceOf('OtherCode\FController\FController', $ctrl);
        return $ctrl;
    }

    /**
     * @depends testInstantiation
     */
    public function testCustomModule(\OtherCode\FController\FController $ctrl)
    {
        $ctrl->setModule('dummy', 'OtherCode\Test\Dummy');

        $data = array('name' => 'Rick');
        $response = $ctrl->run("dummy.sayHello", $data);

        $this->assertInternalType('string', $response);

    }

    /**
     * @depends testInstantiation
     */
    public function testWrongGetLibraryNewInstance(\OtherCode\FController\FController $ctrl)
    {
        $this->assertNull($ctrl->getLibraryNewInstance('Non-existentLibary'));
    }

    /**
     * @depends testInstantiation
     */
    public function testWronggetLibraryInstance(\OtherCode\FController\FController $ctrl)
    {
        $this->assertNull($ctrl->getLibraryInstance('Non-existentLibary'));
    }

    /**
     * @depends testInstantiation
     * @expectedException \OtherCode\FController\Exceptions\FControllerException
     */
    public function testException(\OtherCode\FController\FController $ctrl)
    {
        $ctrl->run("non_existing_module.non_existing_method");
    }

}