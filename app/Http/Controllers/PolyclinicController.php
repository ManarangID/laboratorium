<?php

namespace App\Http\Controllers;

use App\Models\Polyclinic;
use Illuminate\Http\Request;

class PolyclinicController extends Controller
{
    public function index()
    {
        //get polyclinic
        $polyclinic = Polyclinic::all();

        //render view with polyclinic
        return view('polyclinics.index', compact('polyclinic'));
    }

    public function create()
    {
        
        $polyclinic = Polyclinic::all();
        return view('polyclinics.create', compact('polyclinic'));
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */

    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'name'     => 'required'
        ]);
        
        //create polyclinic
            Polyclinic::create([
                'name'     => $request->name,
                'pj'   => $request->pj,
            ]);

        
        //redirect to index
        // return back()->with('success', 'Thank you for submission!');
        return redirect()->route('polyclinic.index')->with('success', 'Register Poliklinik Berhasil');
    }
    
    public function edit(Polyclinic $polyclinic)
    {
        return view('polyclinics.edit', compact('polyclinic'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $polyclinic
     * @return void
     */
    public function update(Request $request, Polyclinic $polyclinic)
    {
        try {
            //validate form
            $this->validate($request, [
                'name'     => 'required'
            ]);
            
                $polyclinic->update([
                    'name'     => $request->name,
                    'pj'     => $request->pj
                ]);
                
            //redirect to index
            return redirect()->route('polyclinic.index')->with(['success' => 'Data Berhasil Diubah!']);
        }  catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'Data Gagal Diubah!']);
       }
    }
    
    /**
     * destroy
     *
     * @param  mixed $polyclinic
     * @return void
     */
    public function destroy(Polyclinic $polyclinic)
    {

        //delete polyclinic
        $polyclinic->delete();

        //redirect to index
        return redirect()->route('polyclinic.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
