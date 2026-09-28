<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProyectoResource extends JsonResource
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

          'name' => $this->name,
          'description' => $this->description,
          'date_finish' => $this->date_finish,
          'empresa' => new EmpresaResource($this->whenLoaded('empresa'))


        ];
    }
}
