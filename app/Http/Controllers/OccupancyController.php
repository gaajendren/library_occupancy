<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Occupancy;
use Illuminate\Http\Request;

class OccupancyController extends Controller
{
    
    public function index()
    {
        $yesterdayDate = Carbon::now('Asia/Kuala_Lumpur')->subDay()->toDateString();


        [$hours, $counts] = $this->hour($yesterdayDate);

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

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show(Occupancy $occupancy)
    {
        //
    }

    
    public function edit(Occupancy $occupancy)
    {
        //
    }

    
    public function update(Request $request, Occupancy $occupancy)
    {
        //
    }

    
    public function destroy(Occupancy $occupancy)
    {
        //
    }
}
