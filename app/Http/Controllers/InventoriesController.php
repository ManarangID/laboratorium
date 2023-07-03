<?php

namespace App\Http\Controllers;

use App\Models\Inventories;
use Illuminate\Http\Request;

class InventoriesController extends Controller
{
    public function index()
    {
        //get inventory
        $inventories = Inventories::all();

        //render view with inventory
        return view('inventories.index', compact('inventories'));
    }

    public function create()
    {
        return view('inventories.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user()->name;

        //validate form
        $this->validate($request, [
            //'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'     => 'required',
            'categories'   => 'required',
            'amount'   => 'required',
        ]);

        if ($request->image != null){
            //upload image
            $image = $request->file('image');
            $image->storeAs('public/inventories', $image->hashName());
            $patientImage = $image->hashName();
        }else{
            $patientImage = "";
        }

        //create patient
            Inventories::create([
                //'image'     => $patientImage,
                'name'   => $request->name,
                'categories'     => $request->categories,
                'amount'   => $request->amount
            ]);

        
        //redirect to index
        // return back()->with('success', 'Thank you for submission!');
        return redirect()->route('inventories.index')->with('success', 'Inventory was added');
    }
}
