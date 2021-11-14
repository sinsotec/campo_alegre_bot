<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Config\Repository;

class articulo extends Model
{

    protected $guarded = [];
    public function __construct(array $attributes = [])
    {
        
        parent::__construct($attributes);

        //config()->set('database.connections.sqlsrv.database', $this->database);
         
        $this->table = DB::raw('dbo.saArticulo');
   }
}
