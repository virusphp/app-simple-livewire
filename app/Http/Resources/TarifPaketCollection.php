<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TarifPaketCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // retur n parent::toArray($request);
        return [
            "tarif" => $this->collection->map(function($paket) use ($request) {
                return (new TarifPaketResource($paket))->toArray($request);
            })
        ];
    }
}
