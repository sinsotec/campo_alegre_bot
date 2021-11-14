<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class empresa extends Model
{
    public function __construct(array $attributes = [])
    {
          parent::__construct($attributes);

          $this->table = DB::raw('[MasterProfitPro].[dbo].[MpEmpresa]');
   }
}
