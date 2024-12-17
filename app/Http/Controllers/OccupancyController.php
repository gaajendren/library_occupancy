<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Occupancy;
use App\Models\Person_enter;
use App\Models\Person_exit;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;

class OccupancyController extends Controller
{
    
    public function index()
    {
        $yesterdayDate = Carbon::now('Asia/Kuala_Lumpur')->subDay()->toDateString();
        $today = Carbon::now('Asia/Kuala_Lumpur')->startOfDay()->toDateString();

        

        [$hours, $counts] = $this->hour($today);

        if(collect($hours)->isEmpty()){
           
            return view('staff.occupancy_report.report')->with('hour_error', 'no data available');
        }

        return view('staff.occupancy_report.report') ->with('hours', $hours)->with('counts', $counts);;
    }

    public function hour($date){

        $record = Occupancy::where('Date', $date)->first();

        if(! $record){
            return [[],[]];
        }

        $count_json = json_decode($record['Count'], true);

        $hour_count = collect($count_json)
                ->groupBy(function($item){
                    return Carbon::parse($item['Time'])->format('H:00');
                })
                ->map(function($items){
                    return $items->sum('Count'); 
                });

        $hours = $hour_count->keys()->toArray();
        $counts = $hour_count->values()->toArray();

        return [$hours,$counts] ;
    }

   
    public function occupancy(){

        $person = Person_enter::whereBetween('timestamp', [Carbon::today('Asia/Kuala_Lumpur')->startOfDay(), Carbon::today('Asia/Kuala_Lumpur')->endOfDay()])->get();
        $person_exit = Person_exit::whereBetween('timestamp', [Carbon::today('Asia/Kuala_Lumpur')->startOfDay(), Carbon::today('Asia/Kuala_Lumpur')->endOfDay()])->get(); 

        $person_at_library = $person->filter(function ($item) {
           
            return $item->person_id_exit === null;
        });

        $person_no_detected = $person_exit->filter(function($item) use($person){
            $is_detect = false;

            foreach ($person as $enter_item) {
                if ($item->id == $enter_item->person_id_exit) {
                    $is_detect = true; 
                    break;            
                }
            }

            return $is_detect === false;

        });

        $sum_no_detect = $person_no_detected->count();

        $sum_person_enter = $person->count(); 

        $sum_person_exit = $person_exit->count();

        $sum_person_at_library = $person_at_library->count();

        return view('staff.occupancy.occupancy', [
            'person' => $person,
            'person_at_library' => $person_at_library,
            'person_exit' => $person_exit,
            'sum_person_enter' => $sum_person_enter,
            'sum_person_exit' => $sum_person_exit,
            'sum_person_at_library' => $sum_person_at_library,
            'sum_no_detect' => $sum_no_detect
        ]);


    }

    public function occupancy_api(Request $request){

        $records = Person_enter::all();

        $exit_records = Person_exit::all();

        foreach ($exit_records as $exit_record) {
            $exit_record->timestamp = Carbon::parse($exit_record->timestamp)->toDateString();
        }

        foreach ($records as $record) {
            $record->timestamp = Carbon::parse($record->timestamp)->toDateString();
        }

        $today = Carbon::now('Asia/Kuala_Lumpur')->toDateString();

        $date = $request->query('date', $today); 
        $sort = $request->query('sort', 'still');

        $date = Carbon::createFromFormat('m/d/Y', $date)->toDateString();

        $person = $records->filter(function ($item) use($date) {
           
            return $item->timestamp == $date;
        });

        $person_exit = $exit_records->filter(function ($item) use($date) {
           
            return $item->timestamp == $date;
        });

        $person_at_library = $person->filter(function ($item) {
           
            return $item->person_id_exit === null;
        });


        $person_no_detected = $person_exit->filter(function($item) use($person){
            $is_detect = false;

            foreach ($person as $enter_item) {
                if ($item->id == $enter_item->person_id_exit) {
                    $is_detect = true; 
                    break;            
                }
            }

            return $is_detect === false;

        });


        if($sort == 'still'){
            $data = $person_at_library;
            $opposite_data = $person_no_detected;
        }
        elseif($sort == 'exit'){
            $data = $person_exit;
            $opposite_data = $person;
        }
        elseif($sort == 'enter'){
            $data = $person;
            $opposite_data = $person_exit;
        }elseif($sort == 'no_detect'){
            $data = $person_no_detected;
            $opposite_data = $person_at_library;
        }
        else{
            return response()->json([
                'error' => 'Invalid sort value',
            ], 400);
        }

        $sum_person_enter = $person->count(); 

        $sum_person_exit = $person_exit->count();

        $sum_person_at_library = $sum_person_enter - $sum_person_exit ;

        $sum_no_detect = $person_no_detected->count();

        return response()->json([
            'data' => $data,
            'opposite' => $opposite_data,
            'sort' => $sort,
            'sum_person_enter' => $sum_person_enter,
            'sum_person_exit' => $sum_person_exit,
            'sum_person_at_library' => $sum_person_at_library,
            'sum_no_detect' => $sum_no_detect
            
        ], 200); 

    }
    

}
