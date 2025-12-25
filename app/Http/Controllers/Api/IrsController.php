<?php

namespace App\Http\Controllers\api;

use App\Actions\Irs\SubmitIrsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIrsRequest;
use App\Http\Resources\IrsResource;
use App\Models\IRS;
use Illuminate\Http\Request;

class IrsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIrsRequest $request, SubmitIrsAction $submitIrsAction)
    {
        $validated = $request->validated();

        $irs = $submitIrsAction->execute(
            $validated, $request->file('file_sks'),
            auth()->id()
        );

        return response()->json([
            'message' => 'Irs Berhasil diunggah',
            'data' => new IrsResource($irs),
            // 'data' => new IrsResource($validated),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(IRS $iRS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IRS $iRS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(IRS $iRS)
    {
        //
    }
}
