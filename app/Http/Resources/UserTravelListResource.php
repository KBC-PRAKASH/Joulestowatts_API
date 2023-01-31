<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\TravelHistory;
use DB;

class UserTravelListResource extends JsonResource
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
            'city_name'    => isset($cityName) && !empty($cityName) ? (String)ucwords(strtolower($cityName)) : '',
            'from_date'    => isset($this->from_date) && !empty($this->from_date) ? (String)$this->from_date : '',
            'to_date'    => isset($this->to_date) && !empty($this->to_date) ? (String)$this->to_date : '',
        ];
    }
}
