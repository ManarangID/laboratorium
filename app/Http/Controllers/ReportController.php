<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        //get exam
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $start = date('Y-m-d', strtotime($start_date));
            $end = date('Y-m-d', strtotime($end_date));
            $hematologi = DB::table('exams')->select(DB::raw('COUNT(hb) as hb'),'exams.date as date')->whereBetween('exams.date',[$start,$end])->groupBy('date')->get();
            $kimiaklinik = DB::table('exams')->select(DB::raw('COUNT(gdp) as gdp'),DB::raw('COUNT(gds) as gds'),DB::raw('COUNT(chol) as chol'),DB::raw('COUNT(au) as au'),'exams.date as date')->whereBetween('exams.date',[$start,$end])->groupBy('date')->get();
            $imunoserologi = DB::table('exams')
                ->select(DB::raw('COUNT(hiv) as hiv'),DB::raw('COUNT(shipi) as shipi'),DB::raw('COUNT(hbsag) as hbsag'),
                DB::raw('COUNT(ns1) as ns1'),DB::raw('COUNT(igg_dengue) as igg_dengue'),DB::raw('COUNT(igm_dengue) as igm_dengue'),DB::raw('COUNT(widal) as widal'),
                DB::raw('COUNT(rdt_malaria) as rdt_malaria'),DB::raw('COUNT(golda) as golda'),DB::raw('COUNT(ag19) as ag19'),
                DB::raw('COUNT(pcr) as pcr'),'exams.date as date')->whereBetween('exams.date',[$start,$end])->groupBy('date')->get();
            $parasitologi = DB::table('exams')->select(DB::raw('COUNT(apusan_malaria) as apusan_malaria'),DB::raw('COUNT(skin_smear_bta) as skin_smear_bta'),DB::raw('COUNT(btas) as btas'),DB::raw('COUNT(btap) as btap'),DB::raw('COUNT(tcm) as tcm'),'exams.date as date')->whereBetween('exams.date',[$start,$end])->groupBy('date')->get();
            $urinalisis = DB::table('exams')
                ->select(DB::raw('COUNT(warna) as warna'),DB::raw('COUNT(kekeruhan) as kekeruhan'),DB::raw('COUNT(ph) as ph'),
                DB::raw('COUNT(kristal) as kristal'),DB::raw('COUNT(bakteri) as bakteri'),DB::raw('COUNT(berat_jenis) as berat_jenis'),
                DB::raw('COUNT(lain_lain) as lain_lain'),DB::raw('COUNT(leukosit_urin_mikro) as leukosit_urin_mikro'),DB::raw('COUNT(eritrosit_urin) as eritrosit_urin'),
                DB::raw('COUNT(reduksi) as reduksi'),DB::raw('COUNT(prot_urine) as prot_urine'),DB::raw('COUNT(keton) as keton'),
                DB::raw('COUNT(bilirubin) as bilirubin'),DB::raw('COUNT(urobilinogen) as urobilinogen'),DB::raw('COUNT(leukosit_urin) as leukosit_urin'),DB::raw('COUNT(nitrit) as nitrit'),
                DB::raw('COUNT(darah) as darah'),DB::raw('COUNT(epitel) as epitel'),DB::raw('COUNT(hialin) as hialin'),
                DB::raw('COUNT(berbutir) as berbutir'),'exams.date as date')->whereBetween('exams.date',[$start,$end])->groupBy('date')->get();
            
                return view('exams.report', compact('hematologi','kimiaklinik','imunoserologi','parasitologi','urinalisis'));
        } else {
            $date = Exam::select('exams.date')->groupBy('date')->get();
            $req = Carbon::parse(request()->tanggal)->toDateTimeString();
            //$hematologi = DB::table('exams')->select(DB::raw('COUNT(hb) as amount'),'exams.date as date',DB::raw('COUNT(rdw) as rdw'))->whereNotNull('hb')->whereNotNull('rdw')->groupBy('date')->get();
            $hematologi = DB::table('exams')->select(DB::raw('COUNT(hb) as hb'),'exams.date as date')->groupBy('date')->get();
            $kimiaklinik = DB::table('exams')->select(DB::raw('COUNT(gdp) as gdp'),DB::raw('COUNT(gds) as gds'),DB::raw('COUNT(chol) as chol'),DB::raw('COUNT(au) as au'),'exams.date as date')->groupBy('date')->get();
            $imunoserologi = DB::table('exams')
                ->select(DB::raw('COUNT(hiv) as hiv'),DB::raw('COUNT(shipi) as shipi'),DB::raw('COUNT(hbsag) as hbsag'),
                DB::raw('COUNT(ns1) as ns1'),DB::raw('COUNT(igg_dengue) as igg_dengue'),DB::raw('COUNT(igm_dengue) as igm_dengue'),DB::raw('COUNT(widal) as widal'),
                DB::raw('COUNT(rdt_malaria) as rdt_malaria'),DB::raw('COUNT(golda) as golda'),DB::raw('COUNT(ag19) as ag19'),
                DB::raw('COUNT(pcr) as pcr'),'exams.date as date')->groupBy('date')->get();
            $parasitologi = DB::table('exams')->select(DB::raw('COUNT(apusan_malaria) as apusan_malaria'),DB::raw('COUNT(skin_smear_bta) as skin_smear_bta'),DB::raw('COUNT(btas) as btas'),DB::raw('COUNT(btap) as btap'),DB::raw('COUNT(tcm) as tcm'),'exams.date as date')->groupBy('date')->get();
            $urinalisis = DB::table('exams')
                ->select(DB::raw('COUNT(warna) as warna'),DB::raw('COUNT(kekeruhan) as kekeruhan'),DB::raw('COUNT(ph) as ph'),
                DB::raw('COUNT(kristal) as kristal'),DB::raw('COUNT(bakteri) as bakteri'),DB::raw('COUNT(berat_jenis) as berat_jenis'),
                DB::raw('COUNT(lain_lain) as lain_lain'),DB::raw('COUNT(leukosit_urin_mikro) as leukosit_urin_mikro'),DB::raw('COUNT(eritrosit_urin) as eritrosit_urin'),
                DB::raw('COUNT(reduksi) as reduksi'),DB::raw('COUNT(prot_urine) as prot_urine'),DB::raw('COUNT(keton) as keton'),
                DB::raw('COUNT(bilirubin) as bilirubin'),DB::raw('COUNT(urobilinogen) as urobilinogen'),DB::raw('COUNT(leukosit_urin) as leukosit_urin'),DB::raw('COUNT(nitrit) as nitrit'),
                DB::raw('COUNT(darah) as darah'),DB::raw('COUNT(epitel) as epitel'),DB::raw('COUNT(hialin) as hialin'),
                DB::raw('COUNT(berbutir) as berbutir'),'exams.date as date')->groupBy('date')->get();
            
            return view('exams.report', compact('hematologi','kimiaklinik','imunoserologi','parasitologi','urinalisis','date'));
        }
        // $exam = Exam::join('patients','exams.id_pasien','=','patients.id')->select('exams.*','patients.rm')->orderBy('id','DESC')->get();

        //render view with exam;
    }
}
