<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function procesar_axios_data( $datos ) : array {
        $objeto_c = []; 
        foreach ($datos as $key => $value) {
            $objeto_c[$key] = $value; 
            $tipo = gettype($value);
            if ($tipo == "object") {
                $s_objeto_c = [];
                foreach ($value as $skey => $svalue) {
                    $s_objeto_c[$skey] = $svalue; 
                }
                $objeto_c[$key] = $s_objeto_c; 
            }                
        }
        return $objeto_c;
    }
}
