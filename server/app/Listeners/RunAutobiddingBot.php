<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class RunAutobiddingBot implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $users = User::whereKeyNot($event->user->id)->whereHas(
            'autoBiddingProducts',
            fn ($query) => $query->where('products.id', $event->product_id)
        )->cursor();

        foreach ($users as $user) {
            $bid_value = (float) ($event->last_bid_value + 1);

            if (! $user->hasUnlimitedMaxBid() && $bid_value > (float) $user->max_bid) {
                continue;
            }

            dispatch(function () use ($user, $event, $bid_value) {
                DB::transaction(function () use ($user, $event, $bid_value) {
                    $user->bids()->create([
                        'product_id' => $event->product_id,
                        'bid_value' => $bid_value
                    ]);
                }, 5);
            });
        }
    }
}
