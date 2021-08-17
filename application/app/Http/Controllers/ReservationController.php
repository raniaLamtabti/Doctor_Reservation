<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $randomNumber = random_int(100000, 999999);

        $reservation = new Reservation();
        $reservation->date = $request->date;
        $reservation->time = $request->time;
        $reservation->doctor_id = $request->doctor;
        $reservation->user_id = Auth::User()->id;
        $reservation->code =  $randomNumber;
        $reservation->status =  'waiting';

        $save = $reservation->save();

        return back()->withInput();
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
        $reservation = Reservation::find($id);

        $reservation->date = $request->date;
        $reservation->time = $request->time;

        $save = $reservation->save();

        return back()->withInput();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $reservation = Reservation::find($id);

        $reservation->status = 'canceled';

        $save = $reservation->save();

        return back()->withInput();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function done($id)
    {
        $reservation = Reservation::find($id);

        $reservation->status = 'done';

        $save = $reservation->save();

        return back()->withInput();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function missed($id)
    {
        $reservation = Reservation::find($id);

        $reservation->status = 'missed';

        $save = $reservation->save();

        return back()->withInput();
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
