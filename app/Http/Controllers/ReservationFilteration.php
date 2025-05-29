<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models;
use App\Models\Room_name;
use App\Models\Room;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationFilteration extends Controller
{

    protected $now;  

    public function __construct()
    {
        $this->now =  Carbon::now('Asia/Kuala_Lumpur');
    }
    
    
 
    public function reservation_daily(){
       
        $reservations = Reservation::with('get_room', 'get_student', 'get_roomType')
        ->whereHas('get_roomType', function ($query) {
            $query->where('slot', 'day');
        })->get()->filter(function ($reservation) {
            return $reservation->date > $this->now->format('Y-m-d'); 
        })->sortBy('date')->values();

       
       
        return $reservations;
        
    }


    public function reservation_montly(){

        $reservations_month = Reservation::with('get_room', 'get_student', 'get_roomType')
        ->whereHas('get_roomType', function ($query) {
            $query->where('slot', 'month');
        })
        ->get()
        ->filter(function ($reservation) {
            return $reservation->date > $this->now->format('Y-m'); 
        })
        ->values();

        $reservationsArray = $reservations_month->toArray();

        usort($reservationsArray, function ($a, $b) {
            return strcmp($a['date'], $b['date']); 
        });

        $reservations_month = $reservationsArray ?? [];

        return $reservations_month;

    }


    public function reservation_hourly(){

        $oneHourLater = $this->now->copy()->addHour();
      
        $now = $this->now;

        $reservations = Reservation::with('get_room', 'get_student', 'get_roomType')
        ->whereHas('get_roomType', function ($query) {
            $query->where('slot', 'hour');
        })->get();
        
        $upcomingReservation = $reservations
            ->filter(function ($reservation) use ($now, $oneHourLater) {
                $timeSlots = json_decode(json_decode($reservation->time, true), true);
        
                if (!$timeSlots) return false;
        
                $reservationDate = Carbon::parse($reservation->date);

                $selectedTime = null;

                if ($reservationDate->setTimezone('Asia/Kuala_Lumpur')->isToday()) {
           
                    $selectedTime = collect($timeSlots)
                                ->map(fn($time) => [
                                    'original' => $time, 
                                    'parsed' => Carbon::parse(trim($time), 'Asia/Kuala_Lumpur')
                                ])
                                ->sortBy('parsed') 
                                ->first(fn($t) => $t['parsed']->greaterThanOrEqualTo($now)); 
                        
                    if($selectedTime){
                        $reservation->selected_time = $selectedTime['original'];
                        return true;
                    }
                }
                $reservation->selected_time = $timeSlots[0];
                return $reservationDate->greaterThanOrEqualTo($now);
            }) ->sortBy(function ($reservation) {
                return [
                    Carbon::parse($reservation->date)->format('Ymd'), 
                    Carbon::parse($reservation->selected_time)->format('Hi')
                ];
            })
            ->values();

            
            $upcomingReservation->each(function ($reservation) use ($upcomingReservation) {
                $reservation->same_time_count = $upcomingReservation
                    ->where('date', $reservation->date)
                    ->where('selected_time', $reservation->selected_time)
                    ->count();
            });

            $upcomingReservation = $upcomingReservation->filter(function ($reservation) {
                return $reservation->same_time_count > 1;
            })->values();

            
            
            return $upcomingReservation;

    }


    public function curent_reservation_hourly(){

        $current_reservations = Reservation::query();
        $now = $this->now;  

        $currentDate = $now->toDateString();        
        $currentHourStart = $now->copy()->startOfHour()->format('H:i');
        $currentHourEnd = $now->copy()->endOfHour()->format('H:i');
        $nextHourStart = $now->copy()->addHour()->startOfHour()->format('H:i');
        $nextHourEnd = $now->copy()->addHour()->endOfHour()->format('H:i');

        
        $current_reservations->where('date', $currentDate)->with('get_room', 'get_student', 'get_roomType')
            ->whereHas('get_roomType', function ($query) {
                $query->where('slot', 'hour');
            })->get();
    
    
        $currentReservations = $current_reservations->get()->filter(function ($reservation) use ($currentHourStart, $currentHourEnd) {
            $timeSlots = json_decode(json_decode($reservation->time, true),true);

            $matchingTimes = collect($timeSlots)->filter(function ($item) use ($currentHourStart, $currentHourEnd) {
                $time = Carbon::createFromFormat('H:i', $item)->format('H:i');
                return $time >= $currentHourStart && $time <= $currentHourEnd;
            });

          
        
            if ($matchingTimes->isNotEmpty()) {
                $reservation->selected_time = $matchingTimes->first(); 
                return true;
            }
        
            return false;
        });

       
        $currentReservations->each(function ($reservation) use ($currentReservations) {
                $reservation->same_time_count = $currentReservations
                    ->where('date', $reservation->date)
                    ->where('selected_time', $reservation->selected_time)
                    ->count();
            });
        
        return $currentReservations;
    
    }


    public function curent_reservation_day(){

        $now = $this->now;  
        $current_reservations = Reservation::query();

        $currentDate = $now->toDateString();        

        $current_reservations = $current_reservations->where('date', $currentDate)->with('get_room', 'get_student', 'get_roomType')
        ->whereHas('get_roomType', function ($query) {
            $query->where('slot', 'day');
        })->get();

        $current_reservations->each(function ($reservation) use ($current_reservations){
            $reservation->same_time_count = $current_reservations->count();
        });

        return $current_reservations;

    }


    public function curent_reservation_month(){

        $currentMonth = $this->now->format('Y-n');

        $reservations_month = Reservation::with('get_room', 'get_student', 'get_roomType')->where('date', $currentMonth)
        ->whereHas('get_roomType', function ($query) {
            $query->where('slot', 'month');
        })
        ->get();
    

        $reservations_month->each(function ($reservation) use ($reservations_month){
            $reservation->same_time_count = $reservations_month->count();
        });

        return $reservations_month;

    }


    public function search(Request $request)
    {
        $query = Reservation::query();
        $room_types = Room::all();

        if ($request->has('search') && $request->filled('search')) {
            $searchTerm = $request->input('search');
            
           
            $searchableColumns = ['time', 'date', 'status', 'studentCount', 'matric_pic', 'ticket_no'];

            $query->where(function ($q) use ($searchTerm, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    $q->orWhere($column, 'LIKE', "%{$searchTerm}%");
                }
            });
    
            $query->orWhereHas('get_student', function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%");
            });

            $query->orWhereHas('get_roomType', function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")->orWhere('slot', 'LIKE', "%{$searchTerm}%");
            });

            $query->orWhereHas('get_room', function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%");
            });
        }

        $reservations = $query->get();

       
        return view('staff.reservation_management.index')->with('reservations', $reservations)->with('room_types', $room_types);
    }



 
}
