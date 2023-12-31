<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TradeOrder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $User)
    {
        // return dd($request);
        
        $User->Asset = $request->Amount;
        $User->save();
        return response()->json('The post successfully Save');
    }

    public function update2(Request $request, User $User)
    {
        // return dd($request);
        
        $User->Asset = $request->Amount;
        $User->remarks = $request->remarks;

        $User->save();
        return response()->json('The post successfully Save');
    }

    public function adminprocess(Request $request){
        // return dd($request);
        $data =  User::all();
        foreach ($data as $item) {
            // pag null at d nabago ni admin ung win or lose
            if($request['preset'] === null  && $item['id'] == $request->User_code){
                echo ('1');
                $total = $item['Asset'] + $request->profit;
                User::where('id', $request->User_code)
                ->update([
                    'Asset' => $item['Asset'] + $request->profit,
                ]);
            return response()->json('The post successfully Updated');
            }
            //pag win 
            else if($request['preset'] === 'Win' && $item['id'] == $request->User_code){
                echo ('2');
                $total = $item['Asset'] + $request->profit;
                User::where('id', $request->User_code)
                ->update([
                    'Asset' => $item['Asset'] + $request->profit,
                ]);
            }
            //pag lose
            else if($request['preset'] === 'Lose' && $item['id'] == $request->User_code){
                echo ('Lose');
                // User::where('id', $request->User_code)
                // ->update([
                //     'Asset' => $item['Asset'] - $request->quantity,
                // ]);
            }
        }
    }

    public function UpdateDrawAsset(Request $request)
    {
        return dd($request);
    }

    public function BetDeduction(Request $request)
    {
        // return dd($request);

        User::where('id', $request->userId)
            ->where('email' , $request->email)
                    // ->where('bankdeposit', $request->bankdeposit)
                    // ->where('depositbranch', $request->depositbranch)
                    
            ->update([
                'Asset' => $request->delection,
            ]);
        return response()->json('The post successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
