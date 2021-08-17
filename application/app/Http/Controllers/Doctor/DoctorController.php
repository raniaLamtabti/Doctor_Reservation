<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Uptime;
use App\Models\Vacation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    function check(Request $request){
         //Validate Inputs
         $request->validate([
            'email'=>'required|email|exists:doctors,email',
            'password'=>'required|min:5|max:30'
         ],[
             'email.exists'=>'This email is not exists in doctors table'
         ]);

         $creds = $request->only('email','password');

         if( Auth::guard('doctor')->attempt($creds) ){
             return redirect()->route('doctor.home');
         }else{
             return redirect()->route('doctor.login')->with('fail','Incorrect credentials');
         }
    }

    function logout(){
        Auth::guard('doctor')->logout();
        return redirect('/home');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctor::get();
        return view('findDr', ['doctors'=> $doctors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request)
    {
        $doctor = $request->input('doctor');
        $city = $request->input('city');
        $specialty = $request->input('specialty');

        if($doctor && $city == '' && $specialty == ''){
            $doctors = Doctor::where('name', 'LIKE', "%{$doctor}%")->get();
        }elseif($city && $doctor == '' && $specialty == ''){
            $doctors = Doctor::where('city_id', $city)->get();
        }elseif($specialty && $doctor == '' && $city == ''){
            $doctors = Doctor::where('specialty_id', $specialty)->get();
        }elseif($doctor && $city && $specialty == ''){
            $doctors = Doctor::where('name', 'LIKE', "%{$doctor}%")
                             ->where('city_id', $city)
                             ->get();
        }elseif($doctor && $specialty && $city == ''){
            $doctors = Doctor::where('name', 'LIKE', "%{$doctor}%")
                             ->where('specialty_id', $specialty)
                             ->get();
        }elseif($city && $specialty && $doctor == ''){
            $doctors = Doctor::where('city_id', $city)
                             ->where('specialty_id', $specialty)
                             ->get();
        }elseif($city && $specialty && $doctor){
            $doctors = Doctor::where('name', 'LIKE', "%{$doctor}%")
                             ->where('city_id', $city)
                             ->where('specialty_id', $specialty)
                             ->get();
        }else{
            $doctors = Doctor::get();
        }

        return view('findDr', ['doctors'=> $doctors]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doctor = Doctor::find($id);
        $uptimes = Uptime::where('doctor_id', $id)->get();
        $vacations = Vacation::where('doctor_id', $id)->get();
        // var_dump($doctor);
        return view('doctor',  compact('doctor', 'uptimes', 'vacations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $doctor = new Doctor();
        $doctor->name = $request->name;
        $doctor->phone = $request->phone;
        $doctor->location = $request->location;
        $doctor->email = $request->email;
        $doctor->city_id = $request->city;
        $doctor->specialty_id = $request->specialty;
        $doctor->description = $request->description;
        $doctor->password =  Str::random(8);
        var_dump($request->image);
        if ($request->hasFile('image')) {
            echo 'ok';
            $fileName = $request->file('image')->getClientOriginalName();
            $request->image->move('doctor/', $fileName);
            $doctor->image = 'doctor/'. $fileName;
        }

        $doctor->status =  'waiting';

        $save = $doctor->save();

        return back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor = Doctor::find($id);
        return view('dashboard.doctor.profile',  compact('doctor'));
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
        $doctor = Doctor::find($id);

        $doctor->name = $request->name;
        $doctor->phone = $request->phone;
        $doctor->location = $request->location;
        $doctor->email = $request->email;
        $doctor->city_id = $request->city;
        $doctor->specialty_id = $request->specialty;
        $doctor->description = $request->description;

        $save = $doctor->save();

        return back()->withInput();
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function updateImage(Request $request, $id)
    {
        $doctor = Doctor::find($id);

        if ($request->hasFile('image')) {
            $fileName = $request->file('image')->getClientOriginalName();
            $request->image->move('doctor/', $fileName);
            $doctor->image = 'doctor/'. $fileName;
        }

        $save = $doctor->save();

        return back()->withInput();
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function updatePassword(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        var_dump($request->password);
        var_dump(Hash::make($request->password));
        var_dump($doctor->password);
        if(Hash::check($request->password, $doctor->password)){
            $doctor->password = Hash::make($request->newPassword);
            $save = $doctor->save();
            return back()->withInput();
        }else{
            return redirect()->route('doctor.editDoctor', ['id' => $doctor->id])->with('fail','Incorrect password');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept($id)
    {
        $doctor = Doctor::find($id);

        $doctor->status = 'accepted';

        $save = $doctor->save();

        return back()->withInput();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject($id)
    {
        $doctor = Doctor::find($id);

        $doctor->status = 'refused';

        $save = $doctor->save();

        return back()->withInput();
    }
}
