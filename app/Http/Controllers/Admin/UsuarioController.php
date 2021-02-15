<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Persona;
use App\Models\Admin\TipoUsuario;
use App\Models\Admin\Usuario;

class UsuarioController extends Controller
{

    public function index()
    {
        $personas = Persona::orderBy('id')->get()->toArray();
        $tipousuarios = TipoUsuario::get()->toArray();
        return view('admin.usuario.index', compact('personas', 'tipousuarios'));
    }

    public function getUsuarios()
    {
        $usuario = Usuario::with('persona', 'tipousuario')->orderBy('id')->get()->toArray();
        $data = [];
        foreach ($usuario as $item) {
            $data[] = [
                'id' => $item['id'],
                'login' => $item['login'],
                'tipousuario' => $item['tipousuario']['nombre'],
                'persona' => ($item['persona']['nombres']) ? $item['persona']['nombres'] : ' - ',
            ];
        }
        return response()->json(array('data' => $data));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'login' => 'required',
            'password' => 'required',
        ]);

        try {
            $usuario = Usuario::create([
                'login' => $request->login,
                'password' => $request->password,
                'tipousuario_id' => $request->tipousuario,
                'persona_id' => $request->persona
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


    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('admin.usuario.show', compact('usuario'));
    }


    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                $usuario = Usuario::with('persona', 'tipousuario')->findOrFail($id)->toArray();
                return response()->json(['data' => $usuario, 'type' => 'success']);
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
            $id = $request->numero_id;
            $usuario = Usuario::findOrFail($id);
            $usuario->update([
                'login' => $request->login2,
                'password' => $request->password2,
                'tipousuario_id' => $request->tipousuario_id2,
                'persona_id' => $request->persona_id2
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


    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                Usuario::destroy($id);
                return response()->json(['message' => 'Se ha eliminado correctamente', 'type' => 'success']);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'No se puede eliminar, ya que hay un recurso más usando este elemento ', 'type' => 'error']);
            }
        } else {
            abort(404);
        }
    }
}