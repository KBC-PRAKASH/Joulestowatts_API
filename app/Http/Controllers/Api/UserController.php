<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, DB;
use App\Models\TravelHistory;
use App\Http\Resources\UserTravelListResource;
use App\Http\Resources\UserTravelCountListResource;

class UserController extends Controller
{
    
    public function travelHistory(Request $request) {
        $results = ["code" => 0, "message" => "Some error occured", "is_validation_error" => false];
        try{
            $inputData = $request->all();

            $validate = \Validator::make($inputData, [
                "user_id"    => "required|numeric",
                "from_date"  => "nullable|date|date_format:Y-m-d",
                "to_date"    => "nullable|date|date_format:Y-m-d",
            ]);
            if($validate->fails()){
                $results['is_validation_error'] = true;
                $results['message'] = $validate->errors();
            }else{
                $query = TravelHistory::where('traveller_id', $inputData['user_id']);
                if(!empty($inputData['from_date']) && !empty($inputData['to_date'])){
                    $query->where('from_date', '>=', $inputData['from_date']);
                    $query->where('to_date', '<=', $inputData['to_date']);
                }
                $result = $query->orderBy('from_date', 'DESC')->get();
                if(count($result) > 0){
                    unset($results['is_validation_error']);
                    $results['code'] = 1;
                    $results['records'] = UserTravelListResource::collection($result);
                    $results['message'] = "Records found successfully";
                }else{
                    $results['message'] = "Records not found";
                }
            }
        }catch(\Exception $e){
            $results['message'] = $e->getMessage();
        }
        return $results;
    }


    public function travellersCountsByCity(Request $request) {
        $results = ["code" => 0, "message" => "Some error occured", "is_validation_error" => false];
        try{
            $inputData = $request->all();

            $validate = \Validator::make($inputData, [
                "from_date"  => "required|date|date_format:Y-m-d",
                "to_date"    => "required|date|date_format:Y-m-d",
            ]);
            if($validate->fails()){
                $results['is_validation_error'] = true;
                $results['message'] = $validate->errors();
            }else{
                $result = TravelHistory::select(
                    '*',
                    \DB::raw("COUNT(DISTINCT(traveller_id)) as total_visited_count"),
                    )
                    ->where('from_date', '>=', $inputData['from_date'])->where('to_date', '<=', $inputData['to_date'])
                    ->groupBy('city_id')->orderBy('total_visited_count','DESC')->get();
                if(count($result) > 0){
                    unset($results['is_validation_error']);
                    $results['code'] = 1;
                    $results['records'] = UserTravelCountListResource::collection($result);
                    $results['message'] = "Records found successfully";
                }else{
                    $results['message'] = "Records not found";
                }
            }
        }catch(\Exception $e){
            $results['message'] = $e->getMessage();
        }
        return $results;
    }
}
