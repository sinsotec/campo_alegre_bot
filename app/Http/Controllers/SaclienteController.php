<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\sacliente;

class SaclienteController extends Controller
{
    protected function index(){
       
        $inventario = DB::table('dbo.v_saStockActual')->where('tipo', 'ACT')->get();
      //  $cantidad = DB::table('dbo.v_saStockActual')->where('co_art', 'PE00009')->where('tipo', 'act')->get();
        //return strval($inventario[0]->stock);

        $cantidad = DB::table('dbo.v_saStockActual')->where([
            ['co_art', 'PE00009'],
            ['tipo', 'act']
        ])
        ->get();


        dd($cantidad[0]);
        
    
    }

}
