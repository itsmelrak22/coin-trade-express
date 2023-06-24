<?php

namespace App\Http\Controllers;

use App\Models\ExchangeHistory;
use App\Models\AgentClient;
use App\Models\Admin;

use Illuminate\Http\Request;

class ExchangeHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return ExchangeHistory::all();

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
        $market = new ExchangeHistory;
        $market->client_id = $request->client_id;
        $market->client_name = $request->client_name;
        $market->exchange_name = $request->exchange_name;

        $market->agent_id = $request->agent_id;
        $market->email = $request->email;
        $market->inviter_email = $request->inviter_email;
        $market->Amount = $request->Amount;
        $market->Asset = $request->Asset;
        $market->prev_Asset = $request->prev_Asset;
        $market->invitation_code = $request->invitation_code;

        $market->save();
        return response()->json('The post successfully Save');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExchangeHistory  $exchangeHistory
     * @return \Illuminate\Http\Response
     */
    public function show(ExchangeHistory $exchangeHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExchangeHistory  $exchangeHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(ExchangeHistory $exchangeHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExchangeHistory  $exchangeHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExchangeHistory $exchangeHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExchangeHistory  $exchangeHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExchangeHistory $exchangeHistory)
    {
        //
    }
    public function withdrawAdd(Request $request)
    {
        
        $adminClients = AgentClient::where('client_id',$request->id)
            ->leftJoin('admins', 'agent_clients.agent_id', 'admins.id')
         ->get();
          
            // ->orderBy('agent_clients.created_at', 'DESC')
          
// return dd($adminClients) ;
    //    $agent =  AgentClient::all();
        // return  dd($agent);
        $market = new ExchangeHistory;
        $market->client_id = $request->id;
        $market->client_name = $request->name;
        $market->exchange_name = 'Withdraw';

        $market->agent_id =$adminClients[0]->agent_id;
        $market->email = $request->email;
        $market->inviter_email = $adminClients[0]->email;
        $market->Amount = $request->prev_Asset;
        $market->Asset = '0';
        $market->prev_Asset = $request->prev_Asset;
        $market->invitation_code = $adminClients[0]->invitation_code;

        $market->save();
        return response()->json('The post successfully Save');

    }
}
