<?php

namespace App\Http\Controllers;

use App\Department;
use App\Appointment;
use App\Doctor;
use App\Http\Requests\Doctor\CreateDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\TimeSchedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DoctorController extends Controller
{

    public function getTimeScheduleByDoctor(Request $request){

        if(!$request->id){
            $html = '<li class="tm"  value="">No Time Schedule For This Doctor</li>';
        }else{
            $html = '';
            $doctor = User::find($request->id);
            $timeSchedules = $doctor->timeSchedules;
            foreach ($timeSchedules as $timeSchedule) {
                $html .= '<li class="tm list-group-item" value="'.$timeSchedule->id.'"><span class="icon icon-clock-o icon-lg icon-fw">'.$timeSchedule->week_day.'</li>';
            }
        }
        return response()->json(['html' => $html]);
    }

    public function getDayoffScheduleByDoctor(Request $request){

        if(!$request->id){
            $html = '<li class="tm"  value="">No Day Off Schedule For This Doctor</li>';
        }else{
            $doctor = User::find($request->id);
            $dayoffSchedules = $doctor->dayoffSchedules;
            $TS = collect();
            foreach ($dayoffSchedules as $dayoffSchedule) {
                    $TS->push($dayoffSchedule);
            }
            $json = $TS->toJson();
        }
        return response()->json(['html' => $json]);
    }

    public function treatmentHistory(User $doctor)
    {
        return view('appointments.list')
        ->with('pendingAppointments', Appointment::where('status','pending')->get())
        ->with('confirmedAppointments', Appointment::where('status','confirmed')->get())
        ->with('cancelledAppointments', Appointment::where('status','cancelled')->get())
        ->with('treatedAppointments', Appointment::where('status','treated')->get())
        ->with('appointments', Appointment::where('doctor_id',$doctor->id)->get());
    }

    public function index()
    {
        return view('users.doctors.list')->with('doctors', User::doctor()->get())->with('departments',Department::all());
    }


    public function create()
    {
        return view('users.doctors.create')->with('departments',Department::all());
    }

    public function store(CreateDoctorRequest $request)
    {

        $doctor = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_id' => $request->national_id,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'emergency' => $request->emergency,
            'medical_degree' => $request->medical_degree,
            'specialist' => $request->specialist,
            'biography' => $request->biography,
            'educational_qualification' => $request->educational_qualification,
            'type' => 'doctor',
        ]);

        if($request->picture){
            $imageName = 'DOCTORSINA_'.Hash('sha1', random_int(100000, 999999)).'.'.$request->picture->extension();  
   
            $request->picture->move(public_path('uploads/doctors_pictures/'), $imageName);

            $doctor->picture = $imageName;
            $doctor->save();
        }

        if ($request->departments){
            $doctor->departments()->attach($request->departments);
        }
        // flash message
        session()->flash('success', 'New Doctor Added Successfully.');
        // redirect user
        return redirect(route('doctors.index'));
    }


    public function show(User $doctor)
    {
        return view('users.doctors.show')->with('doctor', $doctor)->with('departments',Department::all());
    }

    public function edit(User $doctor)
    {
        return view('users.doctors.create')->with('doctor', $doctor)->with('departments',Department::all());
    }


    public function update(UpdateDoctorRequest $request,User $doctor)
    {
        $data = $request->only('first_name','last_name','national_id', 'email', 'address', 'birth_date', 'gender', 'phone', 'mobile', 'emergency', 'medical_degree', 'specialist', 'biography', 'educational_qualification');
        if ($request->hasFile('picture')) {

            $imageName = 'DOCTORSINA_'.Hash('sha1', random_int(100000, 999999)).'.'.$request->picture->extension();  
   
            $request->picture->move(public_path('uploads/doctors_pictures/'), $imageName);

            Storage::delete($doctor->picture);

            $data['picture'] = $imageName;
        }

        if ($request->departments) {
            $doctor->departments()->sync($request->departments);
        }

        $doctor->update($data);
        // flash message
        session()->flash('success', 'Doctor Info Updated Successfully.');
        // redirect user
        if (auth()->user()->type == 'admin') {
        return redirect(route('doctors.index'));
        }else{
            return redirect('/profile/'.auth()->user()->id.'/type');
        }
    }

    public function destroy(User $doctor)
    {
        $doctor->departments()->detach();
        $doctor->timeSchedules()->delete();
        Storage::delete($doctor->picture);
        $doctor->delete();
        // flash message
        session()->flash('success', 'Doctor Deleted Successfully.');
        // redirect user
        return redirect(route('doctors.index'));
    }

}

