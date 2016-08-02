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

    public function sendMessage()
    {
        $this->messages->addMessage('Message 1');
        $this->messages->addMessage('Message 2', 'info');
        $this->messages->addMessage('Message 3', 'notice');
        $this->messages->addMessage('Message 4', 'error');
        $this->messages->addMessage('Message 5', 'warning');
    }

    public function putStuff($stuff){
        $this->storage->stuff = $stuff;
    }
}

class Smart extends \OtherCode\FController\Modules\BaseModule
{
    public function getStuff()
    {
        return $this->storage->stuff;
    }
}

class FControllerTest extends \PHPUnit_Framework_TestCase
{

    public function testInstantiation()
    {
        $ctrl = \OtherCode\FController\FController::getInstance();
        $this->assertInstanceOf('\OtherCode\FController\FController', $ctrl);
        return $ctrl;
    }

    /**
     * @depends testInstantiation
     */
    public function testCustomModule(\OtherCode\FController\FController $ctrl)
    {
        $ctrl->setModule('dummy', '\OtherCode\Test\Dummy');

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
    public function testWrongGetLibraryInstance(\OtherCode\FController\FController $ctrl)
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

    /**
     * @depends testInstantiation
     */
    public function testMessages(\OtherCode\FController\FController $ctrl)
    {
        $ctrl->run('dummy.sendMessage');

        foreach ($ctrl->getMessages() as $message) {

            $this->assertInstanceOf('\OtherCode\FController\Components\Messages\Message', $message);
            $this->assertInternalType('string', $message->type);
            $this->assertInternalType('string', $message->text);
            $this->assertInternalType('string', (string)$message);
            $this->assertContains($message->type, array('info', 'notice', 'error', 'warning'));

        }
    }

    /**
     * @depends testInstantiation
     */
    public function testStore(\OtherCode\FController\FController $ctrl)
    {
        $ctrl->setModule('smart', '\OtherCode\Test\Smart');

        $ctrl->run('dummy.putStuff', array('This is some stuff'));
        $stuff = $ctrl->run('smart.getStuff');

        $this->assertSame($stuff, 'This is some stuff');
    }

}