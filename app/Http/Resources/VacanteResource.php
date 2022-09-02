<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VacanteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'catedra' => $this->catedra,
            'descripcion' => $this->descripcion,
            'fecha_fin' => $this->fecha_fin,
        ];
    }
}

