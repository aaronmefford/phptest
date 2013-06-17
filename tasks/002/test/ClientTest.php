<?php
require_once('lib/Chat.php');
class ClientTest extends PHPUnit_Framework_TestCase {
  public function testClient(){
    $client1 = new Client();
    $client2 = new Client();

    $room = $this->getMock("Room", array());
    $listener = $this->getMock("Listener", array('receive'));
    $listener->expects($this->once())
      ->method("receive")
      ->with($this->equalTo($client1), $this->equalTo($room), $this->equalTo("Hey Susan"));
    $client2->addListener($listener);
    $listener2 = $this->getMock("Listener", array('receive'));
    $listener2->expects($this->once())
      ->method("receive")
      ->with($this->equalTo($client1), $this->equalTo($room), $this->equalTo("Hey Susan"));
    $client2->addListener($listener2);
    $client2->send($client1,$room,'Hey Susan');
  }
}
