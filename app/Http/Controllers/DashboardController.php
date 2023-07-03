<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        //get patient
        $totalPatient = Patient::count();
        $totalExam = Exam::count();
        $totalSession = count(Session::all());

        // $now = Carbon::now()->month;
        $now = Carbon::now()->year;
        $id = Auth::id();
        
        $januari = Exam::whereMonth('date', '=', '01')->whereYear('date',$now)->count();
        $februari = Exam::whereMonth('date', '=', '02')->whereYear('date',$now)->count();
        $maret = Exam::whereMonth('date', '=', '03')->whereYear('date',$now)->count();
        $april = Exam::whereMonth('date', '=', '04')->whereYear('date',$now)->count();
        $mei = Exam::whereMonth('date', '=', '05')->whereYear('date',$now)->count();
        $juni = Exam::whereMonth('date', '=', '06')->whereYear('date',$now)->count();
        $juli = Exam::whereMonth('date', '=', '07')->whereYear('date',$now)->count();
        $agustus = Exam::whereMonth('date', '=', '08')->whereYear('date',$now)->count();
        $september = Exam::whereMonth('date', '=', '09')->whereYear('date',$now)->count();
        $oktober = Exam::whereMonth('date', '=', '10')->whereYear('date',$now)->count();
        $nopember = Exam::whereMonth('date', '=', '11')->whereYear('date',$now)->count();
        $desember = Exam::whereMonth('date', '=', '12')->whereYear('date',$now)->count();
        
        $januariUser = Exam::whereMonth('date', '=', '01')->whereYear('date',$now)->where('created_by',$id)->count();
        $februariUser = Exam::whereMonth('date', '=', '02')->whereYear('date',$now)->where('created_by',$id)->count();
        $maretUser = Exam::whereMonth('date', '=', '03')->whereYear('date',$now)->where('created_by',$id)->count();
        $aprilUser = Exam::whereMonth('date', '=', '04')->whereYear('date',$now)->where('created_by',$id)->count();
        $meiUser = Exam::whereMonth('date', '=', '05')->whereYear('date',$now)->where('created_by',$id)->count();
        $juniUser = Exam::whereMonth('date', '=', '06')->whereYear('date',$now)->where('created_by',$id)->count();
        $juliUser = Exam::whereMonth('date', '=', '07')->whereYear('date',$now)->where('created_by',$id)->count();
        $agustusUser = Exam::whereMonth('date', '=', '08')->whereYear('date',$now)->where('created_by',$id)->count();
        $septemberUser = Exam::whereMonth('date', '=', '09')->whereYear('date',$now)->where('created_by',$id)->count();
        $oktoberUser = Exam::whereMonth('date', '=', '10')->whereYear('date',$now)->where('created_by',$id)->count();
        $nopemberUser = Exam::whereMonth('date', '=', '11')->whereYear('date',$now)->where('created_by',$id)->count();
        $desemberUser = Exam::whereMonth('date', '=', '12')->whereYear('date',$now)->where('created_by',$id)->count();
        
        $female01 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '01')->whereYear('date',$now)->count();
        $female02 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '02')->whereYear('date',$now)->count();
        $female03 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '03')->whereYear('date',$now)->count();
        $female04 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '04')->whereYear('date',$now)->count();
        $female05 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '05')->whereYear('date',$now)->count();
        $female06 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '06')->whereYear('date',$now)->count();
        $female07 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '07')->whereYear('date',$now)->count();
        $female08 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '08')->whereYear('date',$now)->count();
        $female09 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '09')->whereYear('date',$now)->count();
        $female10 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '10')->whereYear('date',$now)->count();
        $female11 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '11')->whereYear('date',$now)->count();
        $female12 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '12')->whereYear('date',$now)->count();
        
        $male01 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '01')->whereYear('date',$now)->count();
        $male02 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '02')->whereYear('date',$now)->count();
        $male03 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '03')->whereYear('date',$now)->count();
        $male04 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '04')->whereYear('date',$now)->count();
        $male05 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '05')->whereYear('date',$now)->count();
        $male06 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '06')->whereYear('date',$now)->count();
        $male07 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '07')->whereYear('date',$now)->count();
        $male08 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '08')->whereYear('date',$now)->count();
        $male09 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '09')->whereYear('date',$now)->count();
        $male10 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '10')->whereYear('date',$now)->count();
        $male11 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '11')->whereYear('date',$now)->count();
        $male12 = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '12')->whereYear('date',$now)->count();
        
        $female01User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '01')->whereYear('date',$now)->where('created_by',$id)->count();
        $female02User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '02')->whereYear('date',$now)->where('created_by',$id)->count();
        $female03User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '03')->whereYear('date',$now)->where('created_by',$id)->count();
        $female04User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '04')->whereYear('date',$now)->where('created_by',$id)->count();
        $female05User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '05')->whereYear('date',$now)->where('created_by',$id)->count();
        $female06User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '06')->whereYear('date',$now)->where('created_by',$id)->count();
        $female07User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '07')->whereYear('date',$now)->where('created_by',$id)->count();
        $female08User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '08')->whereYear('date',$now)->where('created_by',$id)->count();
        $female09User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '09')->whereYear('date',$now)->where('created_by',$id)->count();
        $female10User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '10')->whereYear('date',$now)->where('created_by',$id)->count();
        $female11User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '11')->whereYear('date',$now)->where('created_by',$id)->count();
        $female12User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->whereMonth('date', '=', '12')->whereYear('date',$now)->where('created_by',$id)->count();
        
        $male01User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '01')->whereYear('date',$now)->where('created_by',$id)->count();
        $male02User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '02')->whereYear('date',$now)->where('created_by',$id)->count();
        $male03User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '03')->whereYear('date',$now)->where('created_by',$id)->count();
        $male04User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '04')->whereYear('date',$now)->where('created_by',$id)->count();
        $male05User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '05')->whereYear('date',$now)->where('created_by',$id)->count();
        $male06User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '06')->whereYear('date',$now)->where('created_by',$id)->count();
        $male07User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '07')->whereYear('date',$now)->where('created_by',$id)->count();
        $male08User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '08')->whereYear('date',$now)->where('created_by',$id)->count();
        $male09User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '09')->whereYear('date',$now)->where('created_by',$id)->count();
        $male10User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '10')->whereYear('date',$now)->where('created_by',$id)->count();
        $male11User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '11')->whereYear('date',$now)->where('created_by',$id)->count();
        $male12User = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->whereMonth('date', '=', '12')->whereYear('date',$now)->where('created_by',$id)->count();

        $today = Exam::whereDate( 'date', Carbon::now())->count();        $days = Carbon::now()->dayName;
        $today1 = Exam::whereDate( 'date', Carbon::now()->subDays(1))->count();  $days1 = Carbon::now()->subDay(1)->dayName;
        $today2 = Exam::whereDate( 'date',Carbon::now()->subDays(2))->count();   $days2 = Carbon::now()->subDays(2)->dayName;
        $today3 = Exam::whereDate( 'date', Carbon::now()->subDays(3))->count();  $days3 = Carbon::now()->subDays(3)->dayName;
        $today4 = Exam::whereDate( 'date', Carbon::now()->subDays(4))->count();  $days4 = Carbon::now()->subDays(4)->dayName;
        $today5 = Exam::whereDate( 'date', Carbon::now()->subDays(5))->count();  $days5 = Carbon::now()->subDays(5)->dayName;        
        $today6 = Exam::whereDate( 'date', Carbon::now()->subDays(6))->count();  $days6 = Carbon::now()->subDays(6)->dayName;        
        $totalToday = $today + $today + $today + $today + $today + $today + $today;
        
        $female = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Perempuan')->count();
        $male = Exam::join('patients','exams.id_pasien','=','patients.id')->where('patients.gender','Laki-Laki')->count();
        $gender = $female+$male;
        $percentMale = round($male/$gender*100,2);
        $percentFemale = round($female/$gender*100,2);
        //render view with patient
        return view('exams.dashboard', compact('totalPatient', 'totalExam', 'totalSession', 
                    'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 
                    'september', 'oktober', 'nopember', 'desember', 'today', 'days', 'today1', 'days1', 
                    'januariUser', 'februariUser', 'maretUser', 'aprilUser', 'meiUser', 'juniUser', 'juliUser', 'agustusUser', 
                    'septemberUser', 'oktoberUser', 'nopemberUser', 'desemberUser', 'today', 'days', 'today1', 'days1', 
                    'today2', 'days2', 'today3', 'days3', 'today4', 'days4', 'today5', 'days5', 'today6', 'days6',
                    'percentFemale','percentMale', 'male01', 'male02', 'male03', 'male04', 'male05', 'male06', 'male07', 'male08', 
                    'male09', 'male10', 'male11', 'male12', 'female01', 'female02', 'female03', 'female04', 'female05', 'female06', 'female07', 'female08', 
                    'female09', 'female10', 'female11', 'female12', 'male01User', 'male02User', 'male03User', 'male04User', 'male05User', 'male06User', 'male07User', 'male08User', 
                    'male09User', 'male10User', 'male11User', 'male12User', 'female01User', 'female02User', 'female03User', 'female04User', 'female05User', 'female06User', 'female07User', 'female08User', 
                    'female09User', 'female10User', 'female11User', 'female12User'));
    }

    public function updateProfile(Request $request)
    {
        try {

        $validated = Validator::make($request->all(), [
            'name' => ['required','min:4', 'string', 'max:255'],
            'email' => ['required','email', 'string', 'max:255'],
        ]);
 
        // # check if user profile image is null, then validate
        // if (auth()->user()->profile_image == null) {
        //      $validate_image = Validator::make($request->all(), [
        //         'profile_image' => ['required', 'image', 'max:1000']
        //     ]);
        //      # check if their is any error in image validation
        //     if ($validate_image->fails()) {
        //         return response()->json(['code' => 400, 'msg' => $validate_image->errors()->first()]);
        //     }
        // }
 
        // # check if their is any error
        // if ($validated->fails()) {
        //     return response()->json(['code' => 400, 'msg' => $validated->errors()->first()]);
        // }
 
        # check if the request has profile image
        if ($request->hasFile('profile_image')) {
            $imagePath = 'storage/'.auth()->user()->profile_image;
            # check whether the image exists in the directory
            if (File::exists($imagePath)) {
                # delete image
                File::delete($imagePath);
            }
            $profile_image = $request->profile_image->store('profile_images', 'public');
                    # update the user info
        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'profile_image' => $profile_image ?? auth()->user()->profile_image
        ]);

        }else{
    
            # update the user info
            auth()->user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'nip' => $request->nip
            ]);

        }
        
        //validation rules without images upload

        // $request->validate([
        //     'name' =>'required|min:4|string|max:255',
        //     'email'=>'required|email|string|max:255'
        // ]);

        // $user =Auth::user();
        // $user->name = $request['name'];
        // $user->email = $request['email'];
        // $user->nip = $request['nip'];
        // $user->save();

        //redirect to index
        return redirect()->back()->with(['success' => 'Profile berhasil diubah!']);
    }  catch (\Exception $ex) {
        return redirect()->back()->with(['error' => 'Profile gagal diubah!']);
   }
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        //redirect to index
        return redirect()->back()->with(['success' => 'Password berhasil diubah!']);
    }
}
