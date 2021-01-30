<?php

namespace App\Observers;

use App\Models\Address;

class AddressObserver
{
    /**
     * Handle the address "created" event.
     *
     * @param  \App\Models\Address  $address
     * @return void
     */
    public function creating(Address $address)
    {
        if ($address->default) {
            $address->user->addresses()->update([
                'default' => false,
            ]);
        }
    }
}
