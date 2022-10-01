<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioVacanteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'usuario_id' => $this->usuario_id,
            'vacante_id' => $this->vacante_id,
            'cv' => $this->cv,
            'orden_merito' => $this->orden_merito,
        ];
    }
}
