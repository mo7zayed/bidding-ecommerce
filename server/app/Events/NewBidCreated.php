<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewBidCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;

    public int $product_id;

    public float $last_bid_value;

    public function __construct($user, $product_id, $last_bid_value)
    {
        $this->user = $user;
        $this->product_id = $product_id;
        $this->last_bid_value = $last_bid_value;
    }
}
