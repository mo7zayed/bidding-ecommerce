<?php

namespace App\Http\Controllers\Addresses;

use App\Helpers\Http\Respond;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressesRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Respond::make(
            AddressResource::collection(auth()->user()->addresses)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressesRequest $request)
    {
        if (auth()->user()->addresses()->count() >= 20) {
            return Respond::make([], false, 422, ["You can't have more than 20 addresses"]);
        }

        $address = Address::make($request->validated());

        auth()->user()->addresses()->save($address);

        return Respond::make(new AddressResource($address));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
