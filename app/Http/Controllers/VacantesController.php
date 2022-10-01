<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacanteRequest;
use App\Http\Resources\UsuarioVacanteResource;
use App\Http\Resources\VacanteResource;
use App\Models\Usuario;
use App\Models\UsuarioVacante;
use App\Models\Vacante;
use App\Modules\Auth\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VacantesController extends Controller
{

    public function crear(VacanteRequest $request) {
        $campos = $request->only('catedra', 'descripcion', 'fecha_fin');

        $vacante = Vacante::create([
            'catedra' => $campos['catedra'],
            'descripcion' => $campos['descripcion'],
            'fecha_fin' => $campos['fecha_fin'],
        ]);

        return new VacanteResource($vacante);
    }

    public function listar(Request $request) {
        $filtros = $request->input('filtros', []);
        $vacantes = DB::table("vacantes");

        foreach ($filtros as $key => $value) {
            $vacantes->where($key, 'LIKE', '%'.$value.'%');
        }

        $vacantes = $vacantes->get();

        return $vacantes;
    }

    public function getOne(int $vacanteId) {
        $vacantes = DB::table("vacantes");
        return $vacantes->where('id', '=', $vacanteId)->get();
    }

    public function modificar(int $vacanteId, VacanteRequest $request) {
        $campos = $request->only('catedra', 'descripcion', 'fecha_fin');

        $vacantes = DB::table("vacantes");

        $vacantes->where('id', '=', $vacanteId)->update([
            'catedra' => $campos['catedra'],
            'descripcion' => $campos['descripcion'],
            'fecha_fin' => $campos['fecha_fin'],
        ]);

        return $vacantes->where('id', '=', $vacanteId)->get();
    }

    public function eliminar(int $vacanteId) {
        $vacantes = DB::table("vacantes");
        $usuarios_vacantes = DB::table("usuarios_vacantes");

        $vacantes->where('id', '=', $vacanteId)->delete();
        $usuarios_vacantes->where('vacante_id', '=', $vacanteId)->delete();

        return response()->json([], 200);
    }

    public function postularme(int $vacanteId, Request $request) {
        /** @var Usuario $user */
        $usuario = Auth::user();

        $archivo = $request->file('cv');
        $cv = uniqid() . '*' . $archivo->getClientOriginalName();
        $ruta = public_path() . '/cvs/';
        $archivo->move($ruta, $cv);

        $usuario_vacante = UsuarioVacante::create([
            'usuario_id' => $usuario->id,
            'vacante_id' => $vacanteId,
            'cv' => $cv,
        ]);

        return new UsuarioVacanteResource($usuario_vacante);
    }

    public function misPostulaciones() {
        $usuarios_vacantes = DB::table("usuarios_vacantes");

        /** @var Usuario $user */
        $usuario = Auth::user();

        $postulaciones = $usuarios_vacantes->join('vacantes', 'usuarios_vacantes.vacante_id', '=', 'vacantes.id');
        $postulaciones = $postulaciones->where('usuario_id', '=', $usuario->id)->get();

        return $postulaciones;
    }

}
