<?php
require_once('lib/Chat.php');
class RoomTest extends PHPUnit_Framework_TestCase {
  public function testAddClient(){
    $room = new Room();

    $client1 = $this->getMock("Client", array());
    $room->addClient($client1);
  }
   public function testGetOccupants(){
    $room = new Room();

    $this->assertEquals($room->getOccupants(), array());

    $client1 = $this->getMock("Client", array());
    $client2 = $this->getMock("Client", array());
    $room->addClient($client1);
    $room->addClient($client2);
    $this->assertEquals($room->getOccupants(), array($client1, $client2));

  }
  public function testSend(){
    $room = new Room();

    $this->assertEquals($room->getOccupants(), array());

    $client1 = $this->getMock("Client", array('send'));
    $client2 = $this->getMock("Client", array('send'));

    $client1->expects($this->once())
      ->method("send")
      ->with($this->equalTo($client2), $this->equalTo($room), $this->equalTo("Hey Susan"));

    $client2->expects($this->once())
      ->method("send")
      ->with($this->equalTo($client1), $this->equalTo($room), $this->equalTo("Yeah Bob?"));

    $room->addClient($client1);
    $room->addClient($client2);
    $this->assertEquals($room->getOccupants(), array($client1, $client2));

    $room->send($client2,'Hey Susan');
    $room->send($client1,'Yeah Bob?');
  }
}
