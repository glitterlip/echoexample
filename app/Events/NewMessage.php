<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast {

  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $to;
  public $message;
  public $time;
  public $from;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($sender, $to, $message)
  {
    $this->to = $to;
    $this->message = $message;
    $this->time = now();
    $this->from = $sender;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn()
  {
    return new PrivateChannel('App.User.' . $this->to);
  }


  public function broadcastWith()
  {
    return [
      'id'      => $this->from['id'],
      'name'    => $this->from['name'],
      'time'    => now(),
      'message' => $this->message
    ];

  }
}
