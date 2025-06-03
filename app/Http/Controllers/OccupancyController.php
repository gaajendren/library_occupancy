<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Occupancy;
use App\Models\User;
use App\Models\Room;
use App\Models\Room_name;
use App\Models\Person_enter;
use App\Models\Person_exit;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;

class OccupancyController extends Controller
{

    protected $reservation_report;

    public function __construct(Reservation_report $reservation_report) {
        $this->reservation_report = $reservation_report;
    }
    
    public function index()
    {
        $yesterdayDate = Carbon::now('Asia/Kuala_Lumpur')->subDay()->toDateString();
        $today = Carbon::now('Asia/Kuala_Lumpur')->startOfDay()->toDateString();

        $total_reservation = Reservation::where('date', $today)->count();

        $userCount = User::where('role', 0)->count();
        $roomCount = Room::count();

        [$hours, $counts] = $this->hour($today);

        if(collect($hours)->isEmpty()){
           
            return view('staff.occupancy_report.report')->with('hour_error', 'No Data Available')->with('userCount', $userCount)->with('roomCount', $roomCount)->with('totalReservation', $total_reservation);
        }

        return view('staff.occupancy_report.report')->with('hours', $hours)->with('counts', $counts)->with('userCount', $userCount)->with('roomCount', $roomCount)->with('totalReservation', $total_reservation);
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
                    return round($items->avg('Count'), 2);
                });

        $hours = $hour_count->keys()->toArray();
        $counts = $hour_count->values()->toArray();

        return [$hours,$counts];
    }


    public function date($month){

        $records = Occupancy::whereMonth('Date', $month)->get();

        if(! $records){
            return [[],[]];
        }

        $date = [];
        $counts = [];

        foreach ($records as $record) {
        
            $countData = json_decode($record->Count, true);

        
            $totalCount = 0;
            $entryCount = count($countData);

            
            foreach ($countData as $entry) {
                $totalCount += $entry['Count'];  
            }

            $averageCount = $entryCount > 0 ? round($totalCount / $entryCount, 2) : 0;

            $counts[] = $averageCount;
            $date[] = $record->Date;
        
        }

        return [$date,$counts];

    }


    public function month($year){

        $records = Occupancy::whereYear('Date', $year)->get();

        if(! $records){
            return [[],[]];
        }

        
       
        $groupedByMonth = collect($records)->groupBy(function($item){
            return Carbon::parse($item['Date'])->format('m'); 
        });


        $months = [];
        $counts = [];
    
        
        foreach ($groupedByMonth as $month => $items) {
            $months[] = Carbon::createFromFormat('m', $month)->format('F'); 

            $totalCount = 0;
            $totalEntries = 0;

                foreach ($items as $item) {
                    $countJson = json_decode($item['Count'], true); 
                    $dailyCounts = array_column($countJson, 'Count');

                    $totalCount += array_sum($dailyCounts);
                    $totalEntries += count($dailyCounts);
                }

            $average = $totalEntries > 0 ? round($totalCount / $totalEntries, 2) : 0;
            $counts[] = $average;
        }

        return [$months,$counts];

    }

    public function peakHoursLast30Days()
    {
        $startDate = Carbon::now('Asia/Kuala_Lumpur')->subDays(30)->toDateString();

        $records = Occupancy::where('Date', '>=', $startDate)->get();

        $allCounts = [];

        $times = ['08:00', '09:00','10:00','11:00','12:00','13:00', '14:00', '15:00', '16:00', '17:00'];


        foreach ($records as $record) {
            $count_json = json_decode($record['Count'], true);

            foreach ($count_json as $entry) {
                $hour = Carbon::parse($entry['Time'])->format('H:00');
                if(in_array($hour, $times)){
                    $allCounts[$hour][] = $entry['Count'];
                }
                
            }
        }

        $hourlyAverages = collect($allCounts)->map(function($counts) {
            return round(array_sum($counts) / count($counts), 2);
        });

        $hours = $hourlyAverages->keys()->toArray();
        $averages = $hourlyAverages->values()->toArray();

        // Optionally: Get the peak hour(s)
        $peakValue = max($averages);
        $peakHours = array_keys($averages, $peakValue);

        return response()->json([
            'hours' => $hours,
            'averages' => $averages,
            'peak_hours' => array_map(fn($i) => $hours[$i], $peakHours),
            'peak_value' => $peakValue
        ]);
       
    }




    public function chart(Request $request){

        $range = $request->query('range');

        if ($range === 'date') {
            $date = $request->query('value');
        
            try {
                $formattedDate = Carbon::createFromFormat('m/d/Y', $date)->toDateString();
            } catch (\Exception $e) {
                return response()->json(['error' => 'Invalid date format'], 400);
            }
            
           
            [$hours, $counts] = $this->hour($formattedDate);
    
            return response()->json([$hours, $counts]);
        }


        else if($range === 'month'){
            $month = $request->query('value');
            
            try {
                $monthNumber = Carbon::parse($month)->month;
            } catch (\Exception $e) {
                return response()->json(['error' => 'Invalid date format'], 400);
            }
            
           
            [$date, $counts] = $this->date($monthNumber);
    
            return response()->json([$date, $counts]);
        }

        else if($range === 'year'){
            $year = $request->query('value');

            $year = intval($year);

            [$month, $counts] = $this->month($year);
    
            return response()->json([$month, $counts]);
            
        }

       
    
        return response()->json(['error' => 'Invalid range'], 400);
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


    public function crowd_hour(){

    }



    
    public function room_utilize($type){

        try {
            if ($type == 'hour') {
                $result = $this->reservation_report->utilize_by_hour();
            } elseif ($type == 'day') {
                $result = $this->reservation_report->utilize_by_day();
            } else {
                $result = $this->reservation_report->utilize_by_month();
            }
    
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
       
     }
 
    

}
