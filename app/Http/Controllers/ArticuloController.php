<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\articulo;

class ArticuloController extends Controller
{
    protected function index(){
            $p3 = 'PE00009';
            $p2 = '01';
            try{
                 $cantidad = DB::select('SET NOCOUNT ON; exec [dbo].[pInsertarColor] ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', array('demo4', 'color por telegram3','NULL','NULL','NULL','NULL','NULL','NULL','NULL','NULL','NULL','profit','01','NULL','NULL','NULL'));
           }catch (Throwable $e){
             $cantidad = $e;
           }                             

    //        $articulo = articulo::all();

        //    $cantidad = DB::selectRaw("exec dbo.pConsultarStock(?, ?)", array($p3, $p2));

            dd($cantidad);
            return(compact($articulo[0]['art_des']));

    }


}
