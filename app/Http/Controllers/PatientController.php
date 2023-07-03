<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Patient;
use App\Events\UserLogin;
use App\Models\Polyclinic;
use App\Events\UserPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function index()
    {
        //get patient
        $patient = Patient::all();

        //render view with patient
        return view('patients.index', compact('patient'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function viewPatient(int $patient)
    {
        $patientX = Patient::findOrFail($patient);
        $polyclinic = Polyclinic::all();
        return view('patients.createExam', compact('patientX','polyclinic'));
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generatePatient(int $patient)
    {
        $patientX = Patient::findOrFail($patient);
        $data = ['patientX' => $patientX];
        $pdf = PDF::loadView('patients.print',$data);
        return $pdf->download('invoice'.$patientX->id.'.pdf');
    }

    public function create()
    {
        return view('patients.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */

    public function store(Request $request)
    {
        $name = auth()->user()->name;
        event(new UserPatient($name));

        //validate form
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rm'     => 'required|unique:patients,rm',
            'rm_lama'     => 'required|unique:patients,rm_lama',
            'name'     => 'required',
            'dob'   => 'required',
            'gender'   => 'required',
            'address'   => 'required'
        ]);

        if ($request->image != null){
            //upload image
            $image = $request->file('image');
            $image->storeAs('public/patients', $image->hashName());
            $patientImage = $image->hashName();
        }else{
            $patientImage = "";
        }

        //create patient
            $tanggal = $request->dob;
            $dob = date('Y-m-d', strtotime($tanggal));
            Patient::create([
                'image'     => $patientImage,
                'rm'     => $request->rm,
                'rm_lama'     => $request->rm_lama,
                'name'     => $request->name,
                'dob'   => $dob,
                'gender'     => $request->gender,
                'address'   => $request->address
            ]);

        
        //redirect to index
        // return back()->with('success', 'Thank you for submission!');
        return redirect()->route('patient.index')->with('success', 'Register Pasien Berhasil');
    }
    
    public function edit(Patient $patient)
    {
        //get patient
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $start = date('Y-m-d', strtotime($start_date));
            $end = date('Y-m-d', strtotime($end_date));
            $patientX = Exam::select('exams.*')->where('exams.id_pasien',$patient->id)->whereBetween('exams.date',[$start,$end])->get();
            return view('patients.edit', compact('patient','patientX'));
        } else {
            $patientX = Exam::select('exams.*')->where('exams.id_pasien',$patient->id)->latest()->get();
            return view('patients.edit', compact('patient','patientX'));
        }
        
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $patient
     * @return void
     */
    public function update(Request $request, Patient $patient)
    {
        try {
            //validate form
            $this->validate($request, [
                'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'rm'     => 'required',
                'rm_lama'     => 'required',
                'name'     => 'required',
                'dob'   => 'required',
                'gender'   => 'required',
                'address'   => 'required'
            ]);

            //check if image is uploaded
            if ($request->hasFile('image')) {

                //upload new image
                $image = $request->file('image');
                $image->storeAs('public/patients', $image->hashName());

                //delete old image
                Storage::delete('public/patients/'.$patient->image);

                //update patient with new image
                $tanggal = $request->dob;
                $dob = date('Y-m-d', strtotime($tanggal));
                $patient->update([
                    'image'     => $image->hashName(),
                    'rm'     => $request->rm,
                    'rm_lama'     => $request->rm_lama,
                    'name'     => $request->name,
                    'dob'   => $dob,
                    'gender'     => $request->gender,
                    'address'     => $request->address
                ]);

            } else {

                //update patient without image
                $tanggal = $request->dob;
                $dob = date('Y-m-d', strtotime($tanggal));
                $patient->update([
                    'rm'     => $request->rm,
                    'rm_lama'     => $request->rm_lama,
                    'name'     => $request->name,
                    'gender'     => $request->gender,
                    'dob'   => $dob,
                    'address'     => $request->address
                ]);
            }

            //redirect to index
            return redirect()->route('patient.index')->with(['success' => 'Data Berhasil Diubah!']);
        }  catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'Data Gagal Diubah!']);
       }
    }
    
    /**
     * destroy
     *
     * @param  mixed $patient
     * @return void
     */
    public function destroy(Patient $patient)
    {
        //delete image
        Storage::delete('public/patients/'. $patient->image);

        //delete patient
        $patient->delete();

        //redirect to index
        return redirect()->route('patient.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}
