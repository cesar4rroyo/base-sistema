<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Rol;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::orderBy('id')->pluck('nombre', 'id')->toArray();
        return view('admin.rol.index', compact('roles'));
    }
    public function getRoles()
    {
        $roles = Rol::with('persona')->orderBy('id')->get()->toArray();
        $data = [];
        foreach ($roles as $item) {
            $data[] = [
                'id' => $item['id'],
                'nombre' => $item['nombre'],
            ];
        }
        return response()->json(array('data' => $data));
    }
    public function show($id)
    {
        $rol = Rol::findOrFail($id);
        return view('admin.rol.show', compact('rol'));
    }

    public function update(Request $request)
    {

        try {
            $id = $request->numero_id;
            $rol = Rol::findOrFail($id);
            $rol->update([
                'nombre' => strtoupper($request->nombre2),
            ]);
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

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                $rol = Rol::with('persona')->findOrFail($id)->toArray();
                return response()->json(['data' => $rol, 'type' => 'success']);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'Ha ocurrido un error', 'type' => 'error']);
            }
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'nombre' => 'required',
        ]);

        try {
            $rol = Rol::create([
                'nombre' => strtoupper($request->nombre),
            ]);
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
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                Rol::destroy($id);
                return response()->json(['message' => 'Se ha eliminado correctamente', 'type' => 'success']);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'No se puede eliminar, ya que hay un recurso más usando este elemento ', 'type' => 'error']);
            }
        } else {
            abort(404);
        }
    }
}