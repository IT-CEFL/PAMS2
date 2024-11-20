<?php

namespace App\Http\Controllers;

use App\Type;
use Alert;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $type= new Type;
        $type->typeName = $request->types;
        $type->save();
        
        Alert::success('Sucessful.', 'New item type have been successfully created.');   
        return redirect('/settings');  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $type= Type::find($id);
        $type->typeName = $request->types;
        $type->save();
        
        Alert::success('Sucessful.', 'Item type have been successfully updated.');   
        return redirect('/settings'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type= Type::find($id);
        $type->delete();

        Alert::success('Sucessful.', 'Item type have been successfully deleted.');   
        return redirect('/settings'); 
    }
}
