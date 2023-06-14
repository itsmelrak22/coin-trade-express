<?php

namespace App\Http\Controllers;

use App\Models\BankCard;
use Illuminate\Http\Request;

class BankCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return BankCard::all();

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
        //
        $bankCard = new BankCard;
        $bankCard->UserID = $request->UserID;
        $bankCard->name = $request->name;
        $bankCard->phonenumber = $request->phonenumber;
        $bankCard->bankdeposit = $request->bankdeposit;
        $bankCard->depositbranch = $request->depositbranch;
        $bankCard->bankaccount = $request->bankaccount;
        $bankCard->ifsc = $request->ifsc;
        $bankCard->save();
        return response()->json('The post successfully Save');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankCard  $bankCard
     * @return \Illuminate\Http\Response
     */
    public function show(BankCard $bankCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankCard  $bankCard
     * @return \Illuminate\Http\Response
     */
    public function edit(BankCard $bankCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankCard  $bankCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankCard $bankCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankCard  $bankCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankCard $bankCard)
    {
        //
    }
}
