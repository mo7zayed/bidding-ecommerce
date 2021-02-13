<?php

namespace App\Http\Controllers\User;

use App\Helpers\Http\Respond;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserConfigurationsRequest;
use Illuminate\Http\Request;

class UserConfigurationsController extends Controller
{
    public function update(UserConfigurationsRequest $request)
    {
        auth()->user()->update([
            'max_bid' => $request->max_bid
        ]);

        return Respond::make('Success');
    }
}
