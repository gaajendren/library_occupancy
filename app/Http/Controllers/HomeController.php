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
use DatePeriod;
use DateInterval;

class HomeController extends Controller
{
    public function index(){
       
        $today = Carbon::today();
        $currentHour = Carbon::now('Asia/Kuala_Lumpur')->format('H:i');
        $currentMonth = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m');

        $roomTypes = Room::all();

        $total_room = 0;
        $reserved_slots = 0;

        $now = Carbon::now('Asia/Kuala_Lumpur');
        $today = $now->format('Y-m-d');
        $currentMonth = $now->format('Y-m');
        $countFromTodayOnwards = 0;
        $countTodayOnly=0;

      

        foreach ($roomTypes as $roomType) {
            $rooms = Room_name::where('room_id', $roomType->id)->count();

            $reservations = Reservation::whereHas('get_roomType', function($query) use ($roomType) {
                $query->where('id', $roomType->id);
            });

            if ($roomType->slot == 'hour' || $roomType->slot == 'day') {
                $reservations = $reservations->where('date', $today)->get();
            } elseif ($roomType->slot == 'month') {
                $reservations = $reservations->where('date', '=', $currentMonth)->get();
              
            }
          
           
          
            foreach ($reservations as $reservation) {
                    $time_array = json_decode(json_decode($reservation->time, true), true);

                    if ($roomType->slot == 'hour') {
                         foreach ($time_array as $time) {
                            if ($time == $currentHour) {
                                $reserved_slots++;
                            }
                        }
                    } elseif ($roomType->slot == 'day') {
                        $reserved_slots++;
                        
                    } elseif ($roomType->slot == 'month') {
                        if (Carbon::parse($reservation->date)->format('m') == Carbon::now('Asia/Kuala_Lumpur')->format('m')) {
                            $reserved_slots++;
                           
                        }
                    }
                
            }

            $total_room +=  $rooms;


            $reservationsQuery = Reservation::query()
                ->whereHas('get_roomType', function($query) use ($roomType) {
                    $query->where('id', $roomType->id);
                });

            if ($roomType->slot == 'hour' || $roomType->slot == 'day') {
        
                $countFromTodayOnwards += (clone $reservationsQuery)
                    ->whereDate('date', '>=', $today)
                    ->count();

                $countTodayOnly += (clone $reservationsQuery)
                    ->whereDate('date', '=', $today)
                    ->count();
            } elseif ($roomType->slot == 'month') {
            
                $countFromTodayOnwards += (clone $reservationsQuery)
                    ->where('date', '>=', $currentMonth)
                    ->count();

                $countTodayOnly += (clone $reservationsQuery)
                    ->where('date', '=', $currentMonth)
                    ->count();
            }

    
        }

        $utilization = $total_room > 0 ? ($reserved_slots / $total_room) * 100 : 0;

       
       
        
        return view('staff.dashboard')->with('utilization', $utilization)->with('countFromTodayOnwards',$countFromTodayOnwards)->with('countTodayOnly',$countTodayOnly);
    
    }



    public function fetch_recent_rservation(){
        $reservation_recents = Reservation::orderBy('created_at', 'desc')
                    ->take(4)
                    ->with('get_room')
                    ->with('get_student')
                    ->get();

       return response()->json($reservation_recents);
    }


    public function last6HoursAverages()
    {
        $now = Carbon::now('Asia/Kuala_Lumpur')->startOfHour();
        $startTime = $now->copy()->subHours(6);

        
        $records = Occupancy::where('Date', '>=', $startTime->copy()->toDateString())->get();

        $hourlyBuckets = [];

       for ($i = 5; $i >= 0; $i--) {
            $hour = $now->copy()->subHours($i)->format('H:00');
            $hourlyBuckets[$hour] = [];
        }

        foreach ($records as $record) {
            $count_json = json_decode($record['Count'], true);

            foreach ($count_json as $entry) {
                $timestamp = Carbon::parse($entry['Time'], 'Asia/Kuala_Lumpur')->format('H:00');

                if (isset($hourlyBuckets[$timestamp])) {
                    $hourlyBuckets[$timestamp][] = $entry['Count'];
                }
            }
        }

        $averages = collect($hourlyBuckets)->map(function ($counts) {
            return count($counts) > 0 ? round(array_sum($counts) / count($counts), 2) : 0;
        });

        $labels = $averages->keys()->toArray();   
        $values = $averages->values()->toArray(); 

        return response()->json([
            'hours' => $labels,
            'averages' => $values
        ]);
       
    }


}
