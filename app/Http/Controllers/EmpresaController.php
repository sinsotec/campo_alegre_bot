<?php

namespace App\Http\Controllers;
use App\empresa;
use App\articulo;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index($empresa){
       // dd($empresa);
        $articulo = new articulo([
            'database' =>  $empresa
        ]);
        $articulos = $articulo::all();
        //$empresa = new empresa();
      //  dd($empresa::all());
            dd($articulos);
    }

    public function mostrarInventario(){

        config()->set('database.connections.sqlsrv.database', 'DEMOA');
       
        try{
             $cantidad = DB::select('SET NOCOUNT ON; exec [dbo].[RepStockArticulos]');
       }catch (Throwable $e){
         $cantidad = $e;
       }                             

//        $articulo = articulo::all();

    //    $cantidad = DB::selectRaw("exec dbo.pConsultarStock(?, ?)", array($p3, $p2));

        dd($cantidad);
       //return(json_encode($cantidad));
      //  return(compact($articulo[0]['art_des']));

    }




}
