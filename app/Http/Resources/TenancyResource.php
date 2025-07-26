<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TenancyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'property_id' => $this->property_id,
            'contact_id' => $this->contact_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'rent' => $this->rent,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
