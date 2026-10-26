<?php

namespace Arghavan\CaseCost\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseCostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'consumable_parts_cost' => $this->resource['consumable_parts_cost'] ?? 0,
            'part_repair_cost' => $this->resource['part_repair_cost'] ?? 0,
            'device_repair_cost' => $this->resource['device_repair_cost'] ?? 0,
            'round_trip_repair_cost' => $this->resource['round_trip_repair_cost'] ?? 0,
            'mission_cost' => $this->resource['mission_cost'] ?? 0,
            'petty_cash_cost' => $this->resource['petty_cash_cost'] ?? 0,
            'mapa_center_fix_report' => $this->resource['mapa_center_fix_report'] ?? 0,
            'total_cost' => $this->resource['total_cost'] ?? 0,
            'overhead_cost' => $this->resource['overhead_cost'] ?? 0,
        ];
    }
}
