<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\TravelHistory;
use DB;

class UserTravelCountListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $cityName = \DB::table('cities')->where('id', $this->city_id)->pluck('city_name')->first();
        return [
            'city_name'             => isset($cityName) && !empty($cityName) ? (String)ucwords(strtolower($cityName)) : '',
            'traveller_count'       => isset($this->total_visited_count) && !empty($this->total_visited_count) ? (int)$this->total_visited_count : '',
        ];
    }
}
