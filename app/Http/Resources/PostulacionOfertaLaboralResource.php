<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostulacionOfertaLaboralResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'date_expire' => $this->date_expire,
            'oferta_laboral_id' => $this->oferta_laboral_id,
            'oferta_laboral' => new OfertaLaboralResource($this->whenLoaded('ofertalaboral')),
        ];
    }
}
