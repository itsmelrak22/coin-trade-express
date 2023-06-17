<?php

namespace App\Http\Controllers;

use App\Models\MarketTrade;
use Illuminate\Http\Request;

class MarketTradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return MarketTrade::all();
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
        $market = new MarketTrade;
        $market->No = $request->No;
        $market->Count = $request->Count;
        $market->Direction = $request->direction;
        $market->Price = $request->lastPrice;
        $market->Number = $request->price24hPcnt;

        $market->save();
        return response()->json('The post successfully Save');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MarketTrade  $marketTrade
     * @return \Illuminate\Http\Response
     */
    public function show(MarketTrade $marketTrade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MarketTrade  $marketTrade
     * @return \Illuminate\Http\Response
     */
    public function edit(MarketTrade $marketTrade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MarketTrade  $marketTrade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
 {
    $marketRows = MarketTrade::all();


//update na pala to? bat ganun? hahaha 
 //need k
    if( $request->SymbolName == 'BTCUSDT'){
       $countLength = 1;
       $maxRows = 15;
        $count = 0 ;   
    }
    else if( $request->SymbolName == 'ETHUSDT'){
       $countLength = 15;
       $maxRows = 30;
        $count = 16;  
    }
    else if( $request->SymbolName == 'XRPUSDT'){
       $countLength = 30;
       $maxRows = 45;
        $count = 29;    
    }
    else if( $request->SymbolName == 'LTCUSDT'){
  
      $countLength = 45 ;
       $maxRows = 60;
       $count = 44;    
    }
    else if( $request->SymbolName == 'EOSUSDT'){
       $countLength = 60;
       $maxRows = 75;
       $count = 59; 
    }
    else if( $request->SymbolName == 'BCHUSDT'){
       $countLength = 75;
       $maxRows = 90;
       $count = 74;    
    }
    else if( $request->SymbolName == 'ETCUSDT'){
       $countLength = 90;
       $maxRows = 105;
       $count = 89;
    }
    else if( $request->SymbolName == 'TRBUSDT'){
       $countLength = 105;
       $maxRows = 120;
       $count = 104;
    }
    else if( $request->SymbolName == 'IOTAUSDT'){
       $countLength = 120;
       $maxRows = 135;
       $count = 119;
    }
    else if( $request->SymbolName == 'SNTUSDT'){
       $countLength = 135;
       $maxRows = 150;
       $count = 134;
    }
    else if( $request->SymbolName == 'WICCUSDT'){
       $countLength = 15;
       $maxRows = 165;
       $count = 149;
    }
    else if( $request->SymbolName == 'NEOUSDT'){
       $countLength = 165;
       $maxRows = 180;
       $count = 164;
    }
    else if( $request->SymbolName == 'DOGEUSDT'){
       $countLength = 180;
       $maxRows = 195;
       $count = 189;
    }
    else if( $request->SymbolName == 'HTUSDT'){
       $countLength = 195;
       $maxRows = 210;
       $count = 194;
    }
    else{
       $countLength = 210;
       $maxRows = 225;
       $count = 209;


    }

        for ($i = $maxRows - 1; $i >= $countLength; $i--) {
            $marketRows[$i]->No = $marketRows[$i - 1]->No;
            $marketRows[$i]->Count = $marketRows[$i - 1]->Count;
            $marketRows[$i]->Direction = $marketRows[$i - 1]->Direction;
            $marketRows[$i]->Price = $marketRows[$i - 1]->Price;
            $marketRows[$i]->Number = $marketRows[$i - 1]->Number;
            $marketRows[$i]->updated_at = $marketRows[$i - 1]->updated_at;
            $marketRows[$i]->save();
        }
        // Update the first row with the new data
      
            
       
        $marketRows[$count]->No = $request->SymbolName;
        $marketRows[$count]->Count = $request->Count;
        $marketRows[$count]->Direction = $request->direction;
        $marketRows[$count]->Price = $request->lastPrice;
        $marketRows[$count]->Number = $request->price24hPcnt;
        $marketRows[$count]->updated_at = $request->updated_at;
        $marketRows[$count]->save();
  
    return response()->json('The post has been successfully updated.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MarketTrade  $marketTrade
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarketTrade $marketTrade)
    {
        //
    }
}
