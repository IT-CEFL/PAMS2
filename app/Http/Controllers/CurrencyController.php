<?php

namespace App\Http\Controllers;

use App\Currency;
use Alert;
use Illuminate\Http\Request;

class CurrencyController extends Controller
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
        $currency= new Currency;
        $currency->currencyName = $request->currencyName;
        $currency->save();
        
        Alert::success('Sucessful.', 'New currency have been successfully created.');   
        return redirect('/settings');  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(currency $currency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $currency= Currency::find($id);
        $currency->currencyName = $request->currencyName;
        $currency->save();
        
        Alert::success('Sucessful.', 'Currency have been successfully updated.');   
        return redirect('/settings');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currency= Currency::find($id);
        $currency->delete();

        Alert::success('Sucessful.', 'Currency have been successfully deleted.');   
        return redirect('/settings');  
    }
}
