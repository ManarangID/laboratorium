<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Exam;
use App\Models\User;
use App\Models\Patient;
use App\Events\UserExam;
use App\Models\Polyclinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ExamController extends Controller
{
    public function index()
    {
        //get exam
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $start = date('Y-m-d', strtotime($start_date));
            $end = date('Y-m-d', strtotime($end_date));
            $exam = Exam::join('patients','exams.id_pasien','=','patients.id')->join('users','exams.created_by','=','users.id')->select('exams.*','patients.rm','patients.name as pasien','users.name as uname')->whereBetween('exams.date',[$start,$end])->get();
            return view('exams.index', compact('exam'));
        } else {
            $exam = Exam::latest()->join('patients','exams.id_pasien','=','patients.id')->join('users','exams.created_by','=','users.id')->select('exams.*','patients.rm','patients.name as pasien','users.name as uname')->get();
            return view('exams.index', compact('exam'));
        }
        // $exam = Exam::join('patients','exams.id_pasien','=','patients.id')->select('exams.*','patients.rm')->orderBy('id','DESC')->get();

        //render view with exam;
    }

    public function create()
    {
        
        $patient = Patient::all();
        $polyclinic = Polyclinic::all();
        return view('exams.create', compact('patient','polyclinic'));
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */

    public function patient(Request $request)
    {
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
        return redirect()->route('exam.create')->with('success', 'Register Pasien Berhasil');
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
        event(new UserExam($name));
        
        //validate form
        $this->validate($request, [
            'id_pasien'     => 'required',
            'date'     => 'required'
        ]);

        //create exam
        $userID = Auth::id();
        $tanggal = $request->date;
        $date = date('Y-m-d', strtotime($tanggal));
        Exam::create([
            'date'     => $date,
            'id_pasien'     => $request->id_pasien,
            'id_polyclinic'     => $request->id_polyclinic,
            'golda'     => $request->golda,
            'hb'   => $request->hb,
            'hiv'   => $request->hiv,
            'shipi'   => $request->shipi,
            'hbsag'   => $request->hbsag,
            'gdp'   => $request->gdp,
            'gds'   => $request->gds,
            'chol'   => $request->chol,
            'au'   => $request->au,
            'ns1'   => $request->ns1,
            'igg_dengue'   => $request->igg_dengue,
            'igm_dengue'   => $request->igm_dengue,
            'widal'   => $request->widal,
            'ag19'   => $request->ag19,
            'plano'   => $request->plano,
            'prot_urine'   => $request->prot_urine,
            'reduksi'   => $request->reduksi,
            'btas'   => $request->btas,
            'btap'   => $request->btap,
            'tcm'   => $request->tcm,
            'pcr'   => $request->pcr,
            'leukosit_hema'     => $request->leukosit_hema,
            'eritrosit'     => $request->eritrosit,
            'hematokrit'   => $request->hematokrit,
            'mcv'   => $request->mcv,
            'mch'   => $request->mch,
            'mchc'   => $request->mchc,
            'trombosit'   => $request->trombosit,
            'rdw'   => $request->rdw,
            'neutrofil'   => $request->neutrofil,
            'limfosit'   => $request->limfosit,
            'mxd'   => $request->mxd,
            'apusan_malaria'   => $request->apusan_malaria,
            'rdt_malaria'   => $request->rdt_malaria,
            'skin_smear_bta'   => $request->skin_smear_bta,
            'warna'   => $request->warna,
            'kekeruhan'   => $request->kekeruhan,
            'ph'   => $request->ph,
            'berat_jenis'   => $request->berat_jenis,
            'keton'   => $request->keton,
            'bilirubin'   => $request->bilirubin,
            'urobilinogen'   => $request->urobilinogen,
            'nitrit'   => $request->nitrit,
            'leukosit_urin'   => $request->leukosit_urin,
            'darah'   => $request->darah,
            'epitel'   => $request->epitel,
            'hialin'   => $request->hialin,
            'berbutir'   => $request->berbutir,
            'lain_lain'   => $request->lain_lain,
            'leukosit_urin_mikro'   => $request->leukosit_urin_mikro,
            'eritrosit_urin'   => $request->eritrosit_urin,
            'kristal'   => $request->kristal,
            'bakteri'   => $request->bakteri,
            'diagnosis'   => $request->diagnosis,
            'created_by'   => $userID
        ]);

        
        //redirect to index
        // return back()->with('success', 'Thank you for submission!');
        return redirect()->route('exam.index')->with('success', 'Pemeriksaan Pasien Berhasil');
    }
    
    public function edit(Request $request, Exam $exam)
    {
        $idp = $exam->id_pasien;
        $patient = Patient::all();
        $patientX = Patient::where('patients.id',$idp)->get();
        $poly = $exam->id_polyclinic;
        $polyclinic = Polyclinic::all()->where('id','!=',$poly);
        $polyclinicX = Polyclinic::where('polyclinics.id',$poly)->get();
        return view('exams.edit', compact('exam','patient','patientX','polyclinic','polyclinicX'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $exam
     * @return void
     */
    public function update(Request $request, Exam $exam)
    {
        
        //validate form
        $this->validate($request, [
            'id_pasien'     => 'required',
            'date'     => 'required'
        ]);

        $userID = auth()->id();
        $tanggal = $request->date;
        $date = date('Y-m-d', strtotime($tanggal));
        $exam->update([
            'id_pasien'     => $request->id_pasien,
            'id_polyclinic'     => $request->id_polyclinic,
            'date'   => $date,
            'golda'     => $request->golda,
            'hb'   => $request->hb,
            'hiv'   => $request->hiv,
            'shipi'   => $request->shipi,
            'hbsag'   => $request->hbsag,
            'gdp'   => $request->gdp,
            'gds'   => $request->gds,
            'chol'   => $request->chol,
            'au'   => $request->au,
            'ns1'   => $request->ns1,
            'igg_dengue'   => $request->igg_dengue,
            'igm_dengue'   => $request->igm_dengue,
            'widal'   => $request->widal,
            'ag19'   => $request->ag19,
            'plano'   => $request->plano,
            'prot_urine'   => $request->prot_urine,
            'reduksi'   => $request->reduksi,
            'btas'   => $request->btas,
            'btap'   => $request->btap,
            'tcm'   => $request->tcm,
            'pcr'   => $request->pcr,
            'leukosit_hema'     => $request->leukosit_hema,
            'eritrosit'     => $request->eritrosit,
            'hematokrit'   => $request->hematokrit,
            'mcv'   => $request->mcv,
            'mch'   => $request->mch,
            'mchc'   => $request->mchc,
            'trombosit'   => $request->trombosit,
            'rdw'   => $request->rdw,
            'neutrofil'   => $request->neutrofil,
            'limfosit'   => $request->limfosit,
            'mxd'   => $request->mxd,
            'apusan_malaria'   => $request->apusan_malaria,
            'rdt_malaria'   => $request->rdt_malaria,
            'skin_smear_bta'   => $request->skin_smear_bta,
            'warna'   => $request->warna,
            'kekeruhan'   => $request->kekeruhan,
            'ph'   => $request->ph,
            'berat_jenis'   => $request->berat_jenis,
            'keton'   => $request->keton,
            'bilirubin'   => $request->bilirubin,
            'urobilinogen'   => $request->urobilinogen,
            'nitrit'   => $request->nitrit,
            'leukosit_urin'   => $request->leukosit_urin,
            'darah'   => $request->darah,
            'epitel'   => $request->epitel,
            'hialin'   => $request->hialin,
            'berbutir'   => $request->berbutir,
            'lain_lain'   => $request->lain_lain,
            'leukosit_urin_mikro'   => $request->leukosit_urin_mikro,
            'eritrosit_urin'   => $request->eritrosit_urin,
            'kristal'   => $request->kristal,
            'bakteri'   => $request->bakteri,
            'diagnosis'   => $request->diagnosis,
            'updated_by'   => $userID
        ]);

        //redirect to index
        return redirect()->route('exam.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    
    /**
     * destroy
     *
     * @param  mixed $exam
     * @return void
     */
    public function destroy(Exam $exam)
    {
        //delete exam
        $exam->delete();

        //redirect to index
        return redirect()->route('exam.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function hematologiExam($examHema)
    {
        // $examX = Exam::findOrFail($exam);
        // $idp = $examX->id_pasien;
        // $idu = $examX->created_by;
        // $examXX = Patient::findOrFail($exam);
        // $examXXX = User::findOrFail($idu);
        // return view('exams.hematologi', compact('examX','examXX','examXXX'));
        $examX = Exam::join('patients','exams.id_pasien','=','patients.id')
        ->join('users','exams.created_by','=','users.id')
        ->join('polyclinics','exams.id_polyclinic','=','polyclinics.id')
        ->select('exams.*','exams.id as exam_id','patients.id as patient_id','patients.rm as patient_mr','patients.name as patient_name','patients.gender as patient_gender','patients.address as patient_address','patients.dob as patient_dob','users.name as user_name','polyclinics.name as polyclinic_name','polyclinics.pj as polyclinic_pj')
        ->find($examHema);
        if ($examX){
            return view('exams.hematologi', compact('examX'));
        }else{
            return redirect()->back()->with(['error' => 'Poliklinik belum diatur!']);
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function hasilExam($examHasil)
    {
        // $examX = Exam::findOrFail($exam);
        // $idp = $examX->id_pasien;
        // $idu = $examX->created_by;
        // $examXX = Patient::findOrFail($exam);
        // $examXXX = User::findOrFail($idu);
        // return view('exams.hematologi', compact('examX','examXX','examXXX'));
        $hasil = Exam::join('patients','exams.id_pasien','=','patients.id')
        ->join('users','exams.created_by','=','users.id')
        ->join('polyclinics','exams.id_polyclinic','=','polyclinics.id')
        ->select('exams.*','exams.id as exam_id','patients.id as patient_id','patients.rm as patient_mr','patients.name as patient_name','patients.gender as patient_gender','patients.address as patient_address','patients.dob as patient_dob','users.name as user_name','polyclinics.name as polyclinic_name','polyclinics.pj as polyclinic_pj')
        ->find($examHasil);
        if ($hasil){
            return view('exams.hasil', compact('hasil'));
        }else{
            return redirect()->back()->with(['error' => 'Poliklinik belum diatur!']);
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function urinalisaExam($examUrin)
    {
        // $examX = Exam::findOrFail($exam);
        // $idp = $examX->id_pasien;
        // $idu = $examX->created_by;
        // $examXX = Patient::findOrFail($exam);
        // $examXXX = User::findOrFail($idu);
        // return view('exams.hematologi', compact('examX','examXX','examXXX'));
        $urinalisa = Exam::join('patients','exams.id_pasien','=','patients.id')
        ->join('users','exams.created_by','=','users.id')
        ->join('polyclinics','exams.id_polyclinic','=','polyclinics.id')
        ->select('exams.*','exams.id as exam_id','patients.id as patient_id','patients.rm as patient_mr','patients.name as patient_name','patients.gender as patient_gender','patients.address as patient_address','patients.dob as patient_dob','users.name as user_name','polyclinics.name as polyclinic_name','polyclinics.pj as polyclinic_pj')
        ->find($examUrin);
        if ($urinalisa){
            return view('exams.urinalisa', compact('urinalisa'));
        }else{
            return redirect()->back()->with(['error' => 'Poliklinik belum diatur!']);
        }
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generateExam($exam)
    {
        $examX = Exam::join('patients','exams.id_pasien','=','patients.id')
        ->join('users','exams.created_by','=','users.id')
        ->select('exams.*','patients.id as patient_id','patients.rm as patient_mr','patients.name as patient_name','patients.gender as patient_gender','patients.address as patient_address','patients.dob as patient_dob','users.name as user_name')
        ->find($exam);
        $data = ['examX' => $examX];
        $date = date('dmY', strtotime($examX->date));
        $pdf = PDF::loadView('exams.hematologi',$data);
        return $pdf->download('hematologi-'.$examX->patient_mr.'-'.$examX->patient_name.'-'.$date.'.pdf');
    }

    // public function dashboard()
    // {
    //     //get patient
    //     $totalPatient = Patient::count();
    //     $totalExam = Exam::count();
    //     $totalSession = count(Session::all());

    //     //render view with patient
    //     return view('exams.dashboard', compact('totalPatient', 'totalExam', 'totalSession'));
    // }
}
