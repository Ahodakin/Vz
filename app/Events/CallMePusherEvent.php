<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CallMePusherEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $firstname;
    public $phone;
    public $message;
    public $callMe;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($firstname, $phone, $callMe)
    {
        $this->firstname = $firstname;
        $this->phone = $phone;
        $this->callMe = json_encode($callMe);
        $this->message = "{$firstname} souhaite être appellé au {$phone}";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        //return new Channel('my-channel');
        return ['my-channel'];
    }

    
}
