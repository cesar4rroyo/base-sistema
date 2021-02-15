<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Nacionalidad;

class NacionalidadController extends Controller
{
    public function index(){
        return view('admin.nacionalidad.index');
    }
    
    public function getNacionalidades(){
        $nacionalidad = Nacionalidad::orderBy('nombre')->get()->toArray();
        $data = [];
        $loop=1; 

        foreach ($nacionalidad as $item) {
            $data[]=[
                'numero'=> $loop,
                'nombre'=>$item['nombre'],
                'id'=>$item['id']
            ];
            $loop++;
        }
        return response()->json(array('data' => $data));
    }
}
