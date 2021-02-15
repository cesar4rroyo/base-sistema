<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Nacionalidad;
use App\Models\Admin\Persona;
use App\Models\Admin\Rol;

class PersonaController extends Controller
{

    public function index()
    {
        $roles = Rol::orderBy('id')->pluck('nombre', 'id')->toArray();
        $nacionalidades = Nacionalidad::with('persona')->get();
        return view('admin.persona.index', compact('roles', 'nacionalidades'));
    }

    public function getPersonas()
    {
        $persona = Persona::with('nacionalidad')->orderBy('id')->get()->toArray();
        $data = [];
        foreach ($persona as $item) {
            $data[] = [
                'id' => $item['id'],
                'nombres' => $item['nombres'] . ' ' . $item['apellidos'],
                'direccion' => $item['direccion'],
                'telefono' => $item['telefono'],
                'nacionalidad' => $item['nacionalidad']['nombre'],
                'dni' => $item['dni'],
                'ruc' => $item['ruc'],
                'email' => $item['email'],
                'razonsocial' => $item['razonsocial'],
                'edad' => $item['edad'],
                'sexo' => $item['sexo'],
            ];
        }
        return response()->json(array('data' => $data));
    }

    public function create()
    {
        $nacionalidades = Nacionalidad::with('persona')->get()->toArray();
        $roles = Rol::orderBy('id')->pluck('nombre', 'id')->toArray();
        return response()->json(array('nacionalidades' => $nacionalidades, 'roles' => $roles));
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'dni' => 'nullable|numeric|unique:persona,dni,' . 'id',
            'ruc' => 'nullable|numeric|unique:persona,ruc,' . 'id',
        ]);

        try {
            $persona = Persona::create([
                'nombres' => strtoupper($request->nombres),
                'apellidos' => strtoupper($request->apellidos),
                'razonsocial' => strtoupper($request->razonsocial),
                'direccion' => strtoupper($request->direccion),
                'observacion' => strtoupper($request->observacion),
                'ciudad' => strtoupper($request->ciudad),
                'ruc' => $request->ruc,
                'dni' => $request->dni,
                'sexo' => $request->sexo,
                'fechanacimiento' => $request->fechanacimiento,
                'telefono' => $request->telefono,
                'nacionalidad_id' => $request->nacionalidad_id,
                'email' => $request->email,
                'edad' => $request->edad,
            ]);
            $persona->roles()->sync($request->rol_id);

            return response()->json([
                'message' => 'Se agregado correctamente',
                'type' => 'success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ha ocurrido un error ' . $th->getMessage(),
                'type' => 'error'
            ]);
        }
    }



    public function show($id)
    {
        $persona = Persona::findOrFail($id);
        return view('admin.persona.show', compact('persona'));
    }


    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                $persona = Persona::with('roles', 'nacionalidad')->findOrFail($id)->toArray();
                $roles = [];
                if (count($persona['roles']) != 0) {
                    foreach ($persona['roles'] as $item) {
                        $roles[] =
                            $item['id'];
                    }
                }
                return response()->json(['persona' => $persona, 'roles' => $roles]);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'Ha ocurrido un error', 'type' => 'error']);
            }
        } else {
            abort(404);
        }
    }


    public function update(Request $request)
    {

        try {
            $id = $request->numeroPersona;
            $persona = Persona::findOrFail($id);
            $persona->update([
                'nombres' => strtoupper($request->nombres2),
                'apellidos' => strtoupper($request->apellidos2),
                'razonsocial' => strtoupper($request->razonsocial2),
                'ruc' => $request->ruc2,
                'dni' => $request->dni2,
                'direccion' => strtoupper($request->direccion2),
                'sexo' => $request->sexo2,
                'fechanacimiento' => $request->fechanacimiento2,
                'telefono' => $request->telefono2,
                'observacion' => strtoupper($request->observacion2),
                'nacionalidad_id' => $request->nacionalidad_id2,
                'email' => $request->email2,
                'ciudad' => strtoupper($request->ciudad2),
                'edad' => $request->edad2,

            ]);
            $persona->roles()->sync($request->rol_id2);
            return response()->json([
                'message' => 'Se ha actualizado correctamente',
                'type' => 'success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ha ocurrido un error ' . $th->getMessage(),
                'type' => 'error'
            ]);
        }
    }


    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                Persona::destroy($id);
                return response()->json(['message' => 'Se ha eliminado correctamente', 'type' => 'success']);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'No se puede eliminar, ya que hay un recurso más usando este elemento ', 'type' => 'error']);
            }
        } else {
            abort(404);
        }
    }
}