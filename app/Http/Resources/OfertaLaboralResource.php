<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfertaLaboralResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'name'        => $this->name, // Asegúrate de que estos nombres coincidan con tu BD
            'description' => $this->description,
            'salary'      => $this->salary,
            'date_Expire' => $this->created_at->format('Y-m-d'),
            'empresa'     => new EmpresaResource($this->whenLoaded('empresa')),
            'status_oferta_laboral' => new StatusOfertaLaboralResource($this->whenLoaded('statusofertalaboral')),
        ];
    }
}
