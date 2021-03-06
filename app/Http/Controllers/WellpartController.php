<?php

namespace App\Http\Controllers;

use App\User;
use App\Wellpart;
use Illuminate\Http\Request;

class WellpartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wellparts = Wellpart::all();
        $users = User::all();
        return view('well_part.index', compact('wellparts','users'));
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
        $request->validate([
            'user_id' => 'required|integer',
            'amount' => 'required|integer|gt:0',
            'description' => 'required',
        ]);

        $wellpart = new Wellpart();
        $wellpart->id = $request->serial;
        $wellpart->user_id = $request->user_id;
        $wellpart->amount = $request->amount;
        $wellpart->description = $request->description;
        $wellpart->entry = $request->entry;
        $wellpart->created_at = $request->created_at;
        $wellpart->save();
        return redirect()->back()->with('success','Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wellpart  $wellpart
     * @return \Illuminate\Http\Response
     */
    public function show(Wellpart $wellpart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wellpart  $wellpart
     * @return \Illuminate\Http\Response
     */
    public function edit(Wellpart $wellpart)
    {
        $users = User::all();
        return view('well_part.edit', compact('wellpart','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wellpart  $wellpart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wellpart $wellpart)
    {
        $wellpart->update($request->all());
        return redirect('admin/well_part')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wellpart  $wellpart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wellpart $wellpart)
    {
        $wellpart->delete();
        return redirect()->back()->with('success','Added Successfully');
    }
}
