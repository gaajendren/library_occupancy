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

class Reservation_report extends Controller
{

    
    protected $startDate;
    protected $endDate;
    protected $times;
    protected $formatted_times;
    protected $days;

    public function __construct()
    {
        $this->startDate = Carbon::today()->subDays(30);
        $this->endDate = Carbon::today();
        $this->times = [8,9,10,11,12,13,14,15,16,17];
        $this->formatted_times = array_map(fn($t) => Carbon::createFromFormat('H', $t)->format('H:i'), $this->times);
        $this->days = $this->startDate->diffInDays($this->endDate) + 1;
    }


    public function utilize_by_hour(){

        $roomTypes = Room::where('slot', 'hour')->get();

        $results = [];

        foreach ($roomTypes as $roomType) {
            $rooms = Room_name::where('room_id', $roomType->id)->count();

            $reservations = Reservation::whereHas('get_roomType', function($query) use ($roomType) {
                $query->where('id', $roomType->id);
            })->whereBetween('date', [$this->startDate, $this->endDate])->get();

            $reserved_slots = 0;
            $peak_time_counts = [];

            foreach ($reservations as $reservation) {
                $time_array = json_decode(json_decode($reservation->time, true), true);
                foreach ($time_array as $time) {
                    if (in_array($time, $this->formatted_times)) {
                        $reserved_slots++; 
                    }
                }
            }

            foreach ($this->times as $time) {
    
                $count = $reservations->filter(function ($reservation) use ($time) {
                    $time_array = json_decode(json_decode($reservation->time, true),true);
                    return in_array($time, $time_array); 
                })->count();
            
                $peak_time_counts[$time] = $count;
            }

            $total_possible_slots = $this->days * count($this->times) * $rooms;
            $utilization = $total_possible_slots > 0 ? ($reserved_slots / $total_possible_slots) * 100 : 0;

            $results[] = [
                'room_type' => $roomType->title,
                'reserved_slots' => $reserved_slots,
                'total_slots' => $total_possible_slots,
                'peak_time_counts' => $peak_time_counts,
                'utilization_percent' => round($utilization, 2)
            ];
        }

        
        return $results;

    }


    public function utilize_by_day(){

        $roomTypes = Room::where('slot', operator: 'day')->get();

        $results = [];

        foreach ($roomTypes as $roomType) {
            $rooms = Room_name::where('room_id', $roomType->id)->count();
    
            $reservations = Reservation::whereHas('get_roomType', function($query) use ($roomType) {
                $query->where('id', $roomType->id);
            })->whereBetween('date', [$this->startDate,$this->endDate])->get();
    
            $reserved_slots = $reservations->count();
    
            $total_possible_slots = $this->days * $rooms;
            $utilization = $total_possible_slots > 0 ? ($reserved_slots / $total_possible_slots) * 100 : 0;
    
            $results[] = [
                'room_type' => $roomType->title,
                'reserved_slots' => $reserved_slots,
                'total_slots' => $total_possible_slots,
                'utilization_percent' => round($utilization, 2)
            ];
        }
    
        return $results;

    }

    public function utilize_by_month()
    {
        $startDate = Carbon::today()->subMonths(6)->startOfMonth(); 
        $endDate = Carbon::today()->endOfMonth();
        $roomTypes = Room::where('slot', 'month')->get();
        $results = [];

        foreach ($roomTypes as $roomType) {
            $rooms = Room_name::where('room_id', $roomType->id)->count();

            $reservations = Reservation::whereHas('get_roomType', function($query) use ($roomType) {
                $query->where('id', $roomType->id);
            })->whereBetween('date', [$startDate, $endDate])->get();

          
            $monthly_data = [];

            $period = new DatePeriod($startDate, new DateInterval('P1M'), (clone $endDate)->addMonth());
            $months = iterator_to_array($period);

            foreach ($months as $month) {
                $monthKey = $month->format('Y-m');
                $daysInMonth = Carbon::parse($monthKey . '-01')->daysInMonth;

                $monthly_reservations = $reservations->filter(function($res) use ($monthKey) {
                    return Carbon::parse($res->date)->format('Y-m') === $monthKey;
                });

                $reserved_slots = $monthly_reservations->count();
                $total_slots = $rooms * $daysInMonth;

                $monthly_data[] = [
                    'month' => Carbon::parse($monthKey)->format('F Y'),
                    'reserved_slots' => $reserved_slots,
                    'total_slots' => $total_slots,
                    'utilization_percent' => $total_slots > 0 ? round(($reserved_slots / $total_slots) * 100, 2) : 0,
                ];
            }

            $results[] = [
                'room_type' => $roomType->title,
                'monthly_utilization' => $monthly_data
            ];
        }

        return $results;
    }

}
