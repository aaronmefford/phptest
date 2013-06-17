<?php

class Chat {
	private $clients = array();
	private $rooms = array();

	public function createClient($name) {
		$client = new Client();
		$this->clients[$name] = $client;
		return $client;
	}

	public function createChatroom($roomname) {
		$room = new Room();
		$this->rooms[$roomname] = $room;
		return $room;
	}
}

class Client {
	private $listeners = array();
	
	public function addListener($listener) {
		$this->listeners[] = $listener;
	}
	public function send($sender, $room, $msg) {
		foreach ($this->listeners as $listener ) {
			$listener->receive($sender,$room,$msg);
		}
	}
}

class Room {
	private $clients = array();

	public function addClient($client) {
		$this->clients[] = $client;
	}

	public function getOccupants() {
		return $this->clients;
	}
	public function send($sender,$msg) {
		foreach ($this->clients as $client ) {
			if ( $sender !== $client ) {
				$client->send($sender,$this,$msg);
			}
		}
	}
}

?>
