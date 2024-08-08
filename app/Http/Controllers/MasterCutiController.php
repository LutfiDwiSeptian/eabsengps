<?php

namespace App\Http\Controllers;

use App\Models\master_cuti;
use App\Http\Requests\Storemaster_cutiRequest;
use App\Http\Requests\Updatemaster_cutiRequest;

class MasterCutiController extends Controller
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
     * @param  \App\Http\Requests\Storemaster_cutiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storemaster_cutiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\master_cuti  $master_cuti
     * @return \Illuminate\Http\Response
     */
    public function show(master_cuti $master_cuti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\master_cuti  $master_cuti
     * @return \Illuminate\Http\Response
     */
    public function edit(master_cuti $master_cuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatemaster_cutiRequest  $request
     * @param  \App\Models\master_cuti  $master_cuti
     * @return \Illuminate\Http\Response
     */
    public function update(Updatemaster_cutiRequest $request, master_cuti $master_cuti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\master_cuti  $master_cuti
     * @return \Illuminate\Http\Response
     */
    public function destroy(master_cuti $master_cuti)
    {
        //
    }
}
