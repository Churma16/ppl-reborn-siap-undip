<?php

namespace App\Http\Controllers;

use App\Models\IrsDetail;
use App\Http\Requests\StoreIrsDetailRequest;
use App\Http\Requests\UpdateIrsDetailRequest;

class IrsDetailController extends Controller
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
     * @param  \App\Http\Requests\StoreIrsDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIrsDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IrsDetail  $irsDetail
     * @return \Illuminate\Http\Response
     */
    public function show(IrsDetail $irsDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IrsDetail  $irsDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(IrsDetail $irsDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIrsDetailRequest  $request
     * @param  \App\Models\IrsDetail  $irsDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIrsDetailRequest $request, IrsDetail $irsDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IrsDetail  $irsDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(IrsDetail $irsDetail)
    {
        //
    }
}
