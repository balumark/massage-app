<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;


class JsonResponser extends Facade
{
     protected static function getFacadeAccessor()
     {
          return 'ApiJsonResponser';
     }
}
