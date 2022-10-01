<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Http\Requests\VacanteRequest;
use App\Http\Resources\UsuarioVacanteResource;
use App\Http\Resources\VacanteResource;
use App\Models\Usuario;
use App\Models\UsuarioVacante;
use App\Models\Vacante;
use App\Modules\Auth\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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

    public function getOne(int $vacanteId)
    {
        $vacantes = DB::table("vacantes");
        $vacante = $vacantes->where('id', '=', $vacanteId)->get();

        $usuarios_vacantes = DB::table("usuarios_vacantes");

        $postulaciones = $usuarios_vacantes->join('usuarios', 'usuarios_vacantes.usuario_id', '=', 'usuarios.id');
        $postulaciones = $postulaciones->where('vacante_id', '=', $vacanteId)->select('usuarios.id', 'nombre', 'email', 'orden_merito')->get();

        return new JsonResource([
                "vacante" => $vacante,
                "postulaciones" => $postulaciones
            ]
        );

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

    public function postularme(int $vacanteId, Request $request)
    {
        /** @var Usuario $user */
        $usuario = Auth::user();

        $usuarios_vacantes = DB::table("usuarios_vacantes");

        $resultado = $usuarios_vacantes->where('usuario_id', '=', $usuario->id)->where('vacante_id', '=', $vacanteId)->get();

        if (!$resultado->first()) {
            $archivo = $request->file('cv');
            $cv = uniqid() . '*' . $archivo->getClientOriginalName();
            $ruta = '/public/cvs/';
            $archivo->move($ruta, $cv);

            $usuario_vacante = UsuarioVacante::create([
                'usuario_id' => $usuario->id,
                'vacante_id' => $vacanteId,
                'cv' => $cv,
            ]);

            return new UsuarioVacanteResource($usuario_vacante);
        } else {
            throw new BusinessException('Ya te has postulado a esta vacante');
        }

    }

    public function misPostulaciones() {
        $usuarios_vacantes = DB::table("usuarios_vacantes");

        /** @var Usuario $user */
        $usuario = Auth::user();

        $postulaciones = $usuarios_vacantes->join('vacantes', 'usuarios_vacantes.vacante_id', '=', 'vacantes.id');
        $postulaciones = $postulaciones->where('usuario_id', '=', $usuario->id)->select('catedra', 'fecha_fin', 'orden_merito', 'cv')->get();

        return $postulaciones;
    }

    public function descargarArchivo(string $archivo) {
        $ruta = public_path() ."/cvs/" . $archivo;

        if (file_exists($ruta)) {
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
            return response()->download($ruta, "{$archivo}", $headers);
        } else {
            return "El archivo no existe";
        }
    }

    public function cargarResultados(int $vacanteId, Request $request)
    {
        $largo = count($request->usuarios_id);
        $usuarios_id = $request->usuarios_id;
        $orden_meritos = $request->orden_meritos;

        for($i = 0; $i<$largo; $i++){
            UsuarioVacante::where('usuario_id', '=', $usuarios_id[$i])
                ->where('vacante_id', '=', $vacanteId)->update(
                    [
                        'orden_merito' => $orden_meritos[$i]
                    ]
                );
        }

        return $this->getOne($vacanteId);
    }


}
