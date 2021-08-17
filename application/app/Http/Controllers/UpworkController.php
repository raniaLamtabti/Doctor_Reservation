<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uptime;
use App\Models\Vacation;
use Illuminate\Support\Facades\Auth;

class UpworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::guard('doctor')->user()->id;
        $uptimes = Uptime::where('doctor_id',$id)->get();
        $vacations = Vacation::where('doctor_id',$id)->get();
        $days = array(1,2,3,4,5,6,0);
        foreach($uptimes as $uptime){
            foreach(explode('|', $uptime->days) as $day){
                if (($key = array_search($day , $days)) !== false) {
                    unset($days[$key]);
                }
            }
        }
        return view('dashboard.doctor.uptime',  compact('uptimes', 'vacations', 'days'));
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
        $uptime = new Uptime();
        $uptime->morningFrom = $request->morningFrom;
        $uptime->morningTo = $request->morningTo;
        $uptime->afternoonFrom = $request->afternoonFrom;
        $uptime->afternoonTo = $request->afternoonTo;
        $uptime->eveningFrom = $request->eveningFrom;
        $uptime->eveningTo = $request->eveningTo;
        $uptime->days = implode('|', $request->days);
        $uptime->doctor_id = Auth::guard('doctor')->user()->id;

        $save = $uptime->save();

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
        $uptime = Uptime::find($id);
        $uptime->morningFrom = $request->morningFrom;
        $uptime->morningTo = $request->morningTo;
        $uptime->afternoonFrom = $request->afternoonFrom;
        $uptime->afternoonTo = $request->afternoonTo;
        $uptime->eveningFrom = $request->eveningFrom;
        $uptime->eveningTo = $request->eveningTo;
        $uptime->days = implode('|', $request->days);

        $save = $uptime->save();

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
        $uptime = Uptime::find($id);

        $uptime->delete();

        return back()->withInput();
    }
}
