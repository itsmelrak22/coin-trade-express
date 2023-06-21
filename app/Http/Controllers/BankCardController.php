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
    public function index($id)
    {
        // return dd($id);
        //
        // return BankCard::all();
        $bankCards = BankCard::where('deleted_at', null)
                    ->where('UserID', $id)->get();
        return $bankCards;

    }
    public function basicinfo($name)
    {
        $bankCards = BankCard::where('bankdeposit', $name)->get();
        return $bankCards;
        // $bankCards = BankCard::where('deleted_at', null)->get();
        // return dd($id);
    //     return BankCard::select('bank_cards.*')->where('name', '=', 'jude55')->get();
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
    public function update(Request $request)
    {
        // return dd($request);
        try{
            BankCard::where('name', $request->name)
            ->where('bankaccount' , $request->bankaccount)
                    // ->where('bankdeposit', $request->bankdeposit)
                    // ->where('depositbranch', $request->depositbranch)
                    
            ->update([
                'UserID' => $request->UserID,
                'name' => $request->name,
                'phonenumber' => $request->phonenumber,
                'bankdeposit' => $request->bankdeposit,
                'depositbranch' => $request->depositbranch,
                'bankaccount' => $request->bankaccount,
                'ifsc' => $request->ifsc,
            ]);
        return response()->json('The post successfully Updated');
        }catch(Exception $e){
            echo "Error updating";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankCard  $bankCard
     * @return \Illuminate\Http\Response
     */
    public function Delete(Request $request)
    {
        // return dd(date('Y-m-d H:i:s'));
        try{
            BankCard::where('name', $request->name)
            ->where('bankaccount' , $request->bankaccount)
                   
                    
            ->update([
                'deleted_at' => date('Y-m-d H:i:s')
            ]);
        return response()->json('The post successfully Deleted');
        }catch(Exception $e){
            echo "Error updating";
        }
    }
    
    
}