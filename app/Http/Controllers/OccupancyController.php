<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Occupancy;
use App\Models\Person_enter;
use App\Models\Person_exit;
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
        $person_exit = Person_exit::all(); 

        $person_at_library = $person->filter(function ($item) {
           
            return $item->person_id_exit === null;
        });


        return view('staff.occupancy.occupancy', [
            'person' => $person,
            'person_at_library' => $person_at_library,
            'person_exit' => $person_exit,
        ]);


    }

}
