<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models;
use App\Models\Room_name;
use App\Models\Room;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\ReservationFilteration;
use App\Events\ReservationNotification;
use App\Models\Setting;

class ReservationController extends Controller
{

    protected $reservationFilter;

    public function __construct(ReservationFilteration $reservationFilter)
    {
        $this->reservationFilter = $reservationFilter;
    }




    public function print($ticket){
        $reservation = Reservation::where('ticket_no', $ticket)->first();

        return view('student.ticket')->with('reservation', $reservation);
    }

  
    public function index()
    {
        $reservations = Reservation::orderBy('created_at', 'desc')->paginate(15);
        $room_types = Room::all();

        return view('staff.reservation_management.index')->with('reservations', $reservations)->with('room_types', $room_types);
    }

    public function show($id){
        
        $reservation = Reservation::find($id);

        return view('staff.reservation_management.view')->with('reservation', $reservation);
    }

    public function sort(Request $request)
    {
        $validated = $request->validate([
            'sort_by' => 'required|in:date,time,status,studentCount', 
            'sort_dir' => 'required|in:asc,desc'
        ]);

        $query = Reservation::query();

        if ($validated['sort_by'] === 'time') {

            $query->orderByRaw("CAST(JSON_UNQUOTE(JSON_EXTRACT(time, '$[0]')) AS TIME) {$validated['sort_dir']}");
        }
        
        else {
            
            $query->orderBy($validated['sort_by'], $validated['sort_dir']);
        }

      
        return response()->json([
            'reservations' => $query->get()->map(function($reservation) {
                return [
                    ...$reservation->toArray(),
                    'get_room' => $reservation->get_room,
                    'get_roomType' => $reservation->get_roomType,
                    'get_student' => $reservation->get_student
                ];
            })
        ]);
    }


    public function filter(Request $request){

        $date = $request->query('date');
        $room_type = $request->query('room_type');
        $status = $request->query('status');
       

        $query = Reservation::query();

        if($date != 'all'){
            $formattedDate = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
            $query->where('date', $formattedDate);
        }
        if ($room_type !== 'all') {
            $query->where('roomTypeId', $room_type);
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        
        return response()->json([
            'reservations' => $query->get()->map(function($reservation) {
                return [
                    ...$reservation->toArray(),
                    'get_room' => $reservation->get_room,
                    'get_roomType' => $reservation->get_roomType,
                    'get_student' => $reservation->get_student
                ];
            })
        ]);

    }


    


    public function store_day(Request $request, $id ){

        $input = $request->all();
   
        $rules =[
            'img' => 'required', 
            'img.*' => 'mimes:png,jpg,jpeg,gif,svg|max:2048',
            'date' => 'required',
            'room_id'=>'required',
            'studentCount' => 'required|integer'
           ];
    
        $messages = [
            'img.required' => 'An image file is required.',
            'date.required' => 'The date field is required.',
            'studentCount.integer' => 'The count of student must be an integer.',
            'room_id'=>'The room field is required.',
            'time.required' => 'The time field is required.'
        ];

        $request->validate($rules, $messages);

        try{

            $date  = $input['date'];

           

            $reservations = Reservation::where('roomTypeId', $id)->with('get_room')->with('get_roomType')->where('date', $date)->get();
        
            if($reservations->first()){

                $book_limit_day = $reservations->first()->get_roomType->qty;

                if ($reservations->count() >= $book_limit_day){
                   return redirect()->back()->with('error', 'Sorry. Selected room alreday reserve.');
                }

            }

            }catch(\Exception $e){
               dd($e->getMessage());
            }

         try{

            $sameDayReservation = Reservation::where('created_at', Carbon::today())->where('studentId', auth()->user()->id)->get();

            if(!$sameDayReservation->isEmpty()){
             return redirect()->back()->with('error', 'Already reserve a room !!! Only one reservation allowed per day');
            }
     
             $filenames = array();
     
             if ($request->hasFile('img')) {
                 
                 foreach ($request->file('img') as $image) {
                     
                     $filename = $image->getClientOriginalName();
                     $uniqueFilename = time() . '_' . $filename; 
                     $image->storeAs('student_matrix', $uniqueFilename, 'public');
                     $filenames[] = $uniqueFilename;
                 }
             } else {
                 dd('No files found');
             }
     
             $input['matric_pic'] = json_encode($filenames);  
     
             $input['studentId'] = auth()->user()->id; 
             $input['status'] = 'pending';
             $input['roomTypeId'] = $id;
             $input['roomId'] = $input['room_id'];
             $input['date'] = $date;

             $input['ticket_no'] =  'RD-' . auth()->user()->id . $input['room_id'] . '-' . rand(10000, 99999);

             $reservation = Reservation::create($input);

             event(new ReservationNotification($reservation));

             return redirect()->route('student.dashboard')->with('success', 'Successfully Reserved !!!');
 

         }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());

         }

    }



    public function store_month(Request $request, $id ){
        $input = $request->all();

       
        
        $rules =[
            'img' => 'required', 
            'img.*' => 'mimes:png,jpg,jpeg,gif,svg|max:2048',
            'date' => 'required',
            'room_id'=>'required',
            'studentCount' => 'required|integer'
           ];
    
        $messages = [
            'img.required' => 'An image file is required.',
            'date.required' => 'The date field is required.',
            'studentCount.integer' => 'The count of student must be an integer.',
            'room_id'=>'The room field is required.',
        ];

        $request->validate($rules, $messages);

        try{

            $date  = $input['date'];
            $reservations = Reservation::where('roomTypeId', $id)->with('get_room')->with('get_roomType')->where('date', $date)->get();
        
            if($reservations->first()){

                $book_limit_month = $reservations->first()->get_roomType->qty;

                if ($reservations->count() >= $book_limit_month){
                   return redirect()->back()->with('error', 'Sorry. Selected room alreday reserve.');
                }

            }

            }catch(\Exception $e){
               dd($e->getMessage());
            }

         try{

            $sameDayReservation = Reservation::where('created_at', Carbon::today())->where('studentId', auth()->user()->id)->get();

            if(!$sameDayReservation->isEmpty()){
                return redirect()->back()->with('error', 'Already reserve a room !!! Only one reservation allowed per day');
            }
     
             $filenames = array();
     
             if ($request->hasFile('img')) {
                 
                 foreach ($request->file('img') as $image) {
                     
                     $filename = $image->getClientOriginalName();
                     $uniqueFilename = time() . '_' . $filename; 
                     $image->storeAs('student_matrix', $uniqueFilename, 'public');
                     $filenames[] = $uniqueFilename;
                 }
             } else {
                 dd('No files found');
             }
     
             $input['matric_pic'] = json_encode($filenames);  
     
             $input['studentId'] = auth()->user()->id; 
             $input['status'] = 'pending';
             $input['roomTypeId'] = $id;
             $input['roomId'] = $input['room_id'];
             $input['date'] = $date;

             $input['ticket_no'] =  'RM-' . auth()->user()->id . $input['room_id'] . '-' . rand(10000, 99999);

           
             $reservation = Reservation::create($input);

             event(new ReservationNotification($reservation));

             return redirect()->route('student.dashboard')->with('success', 'Successfully Reserved !!!');
 

         }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());

         }
        
    }

  


   
    public function store(Request $request, $id )
    {

        $input = $request->all();
        $input['room_id'] = json_decode($input['room_id'] , true);
       
        dd($request->all());

        $rules =[
            'img' => 'required', 
            'img.*' => 'mimes:png,jpg,jpeg,gif,svg|max:2048',
            'date' => 'required',
            'time' => 'required',
            'room_id'=>'required',
            'studentCount' => 'required|integer'
           ];
    
        $messages = [
            'img.required' => 'An image file is required.',
            'date.required' => 'The date field is required.',
            'studentCount.integer' => 'The count of student must be an integer.',
            'room_id'=>'The room field is required.',
            'time.required' => 'The time field is required.'
        ];

        $request->validate($rules, $messages);

        $room_reservations = array();

        try{

            $roomReservations = collect($input['room_id'])
            ->reduce(function ($carry, $item) {
                foreach ($item as $roomId => $time) {
                    $carry[$roomId][] = $time; 
                }
                return $carry;
            }, []);
            
        
            $date = $input['date'];
            
    
            $roomIds = array_keys($roomReservations);
            
          
            $rooms = Room_name::whereIn('id', $roomIds)->get();
            
            $bookedRooms = [];
  
            foreach ($rooms as $room) {

                $times = $roomReservations[$room->id]; 
            
                $reservations = $room->get_reservations->where('date', $date);

                foreach ($times as $time) { 
                    $isBooked = $reservations->map(function ($reservation) use ($time) {
                        $timeS = collect(json_decode(json_decode($reservation->time), true));
                        
                        return $timeS->contains(function ($t) use ($time) {
                            return Carbon::createFromFormat('H:i', $t)->hour == $time;
                        });
                    })->contains(true);
            
                    if ($isBooked) {
                        $bookedRooms[] = ['room_id' => $room->room_id, 'time' => $time];
                    }
                }
            }
        

        if (!empty($bookedRooms)) {
            return redirect()->back()->with('error', 'Sorry. Selected room alreday reserve. ');
        }else{
            $room_reservations = $roomReservations;
        }

        }catch(\Exception $e){
            dd($e);
        }


        try{

            
       $sameDayReservation = Reservation::where('created_at', Carbon::today())->where('studentId', auth()->user()->id)->get();

       if(!$sameDayReservation->isEmpty()){
        return redirect()->back()->with('error', 'Already reserve a room !!! Only one reservation allowed per day');
       }

        $filenames = array();

        if ($request->hasFile('img')) {
            
            foreach ($request->file('img') as $image) {
                
                $filename = $image->getClientOriginalName();
                $uniqueFilename = time() . '_' . $filename; 
                $image->storeAs('student_matrix', $uniqueFilename, 'public');
                $filenames[] = $uniqueFilename;
            }
        } else {
            dd('No files found');
        }

        $input['matric_pic'] = json_encode($filenames);  

        if($input['time']) {
            $input['time'] = json_encode($input['time']);
        }

        $input['studentId'] = auth()->user()->id; 
        $input['status'] = 'pending';
        $input['roomTypeId'] = $id;

      
         $random_id = rand(10000, 99999);

    
        foreach ($room_reservations as $key => $room_reservation) {
          
           
            $input['roomId'] = $key;
            $formattedTimes = array_map(fn($time) => sprintf('%02d:00', $time), $room_reservation);
            $input['time'] = json_encode(json_encode($formattedTimes));

            if(collect($room_reservations)->count() > 1){
                $input['ticket_no'] =  'RHJ-' . auth()->user()->id. '-' . $random_id;
            }else{
                $input['ticket_no'] =  'RH-' . auth()->user()->id . $key . '-' . $random_id;
            }

            
            $reservation = Reservation::create($input)->fresh();

            event(new ReservationNotification($reservation));
           
        }

        return redirect()->route('student.dashboard')->with('success', 'Successfully Reserved !!!');


       }catch(\Exception $e){

        return redirect()->back()->with('error', 'Error on reservation. Try again !!!'.$e);
       }

        
    }



    public function api_slot(Request $request, $id, $date){

      try{

        $reservations = Reservation::where('roomTypeId', $id)->where('date', $date)->get();
        $totalSlot = Room::find($id);

         if($reservations){

            $totalRooms = Room_name::where('room_id', $id)->count();

            $reservedTimes = $reservations->pluck('time')->map(function ($time) {
                return collect(json_decode(json_decode($time), true))->map(function ($t) {
                    return Carbon::createFromFormat('H:i', $t)->hour; 
                });
            })->flatten()->toArray();

            $timeSlots = [8,9,10,11,12,13,14,15,16,17];

            $availability = [];

            foreach ($timeSlots as $hour) {
            
                $bookedCount = collect($reservedTimes)->filter(fn ($t) => $t == $hour)->count();

                if ($bookedCount < $totalRooms) {
            
                    $availableRoom = Room_name::where('room_id', $id)
                    ->get()
                    ->filter(function ($room) use ($date, $hour) {
                    
                        $reservations = $room->get_reservations->where('date', $date);
                
                      
                        $isBooked = $reservations->map(function ($reservation) use ($hour) {
                            $times = collect(json_decode(json_decode($reservation->time), true));
                
                            return $times->contains(function ($t) use ($hour) {
                                return Carbon::createFromFormat('H:i', $t)->hour == $hour;
                            });
                        })->contains(true);
                
                        return !$isBooked; 
                    })
                    ->pluck('id') 
                    ->toArray();

                    
                   
                    $availability[] = [
                        'hour' => $hour,
                        'available' => true,
                        'room_id' =>  $availableRoom[0] ?? null, 
                        
                    ];
                } else {
                
                    $availability[] = [
                        'hour' => $hour,
                        'available' => false,
                        'room_id' => null
                        
                    ];
                }
            }
            return response()->json([$availability, $totalSlot->max_slot]);
           
        }else{
            return response()->json(['hehe']);
        }

     
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function api_CalenderSlot($id, $date)
{
    try {
        $reservations = Reservation::where('roomTypeId', $id)->where('date', $date)->get();
        $totalSlot = Room::find($id);

        if (!$reservations) {
            return response()->json(['resources' => [], 'events' => []]);
        }

        $roomNames = Room_name::where('room_id', $id)->get();
        $resources = $roomNames->map(function ($room) {
            return [
                'id' =>  $room->id,
                'title' => $room->name,
            ];
        });

        $timeSlots = [8,9,10,11,12,13,14,15,16,17];
        $events = [];

        foreach ($roomNames as $room) {
            foreach ($timeSlots as $hour) {
                $reservationsForRoom = $room->get_reservations->where('date', $date);

                $isBooked = $reservationsForRoom->map(function ($reservation) use ($hour) {
                    $times = collect(json_decode(json_decode($reservation->time), true));
                    return $times->contains(function ($t) use ($hour) {
                        return Carbon::createFromFormat('H:i', $t)->hour == $hour;
                    });
                })->contains(true);

                if ($isBooked) {
                    $start = Carbon::parse($date)->setHour($hour)->format('Y-m-d\TH:i:s');
                    $end = Carbon::parse($date)->setHour($hour + 1)->format('Y-m-d\TH:i:s');

                    $events[] = [
                        'title' => 'Unavailable',
                        'start' => $start,
                        'end' => $end,
                        'resourceId' =>  $room->id,
                        'display' => 'background',
                        'overlap' => false,
                        'color' => 'red', 
                       
                    ];
                }
            }
        }

        return response()->json(data: [
            'resources' => $resources,
            'events' => $events,
            'max_slot' => $totalSlot->max_slot
        ]);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $rules =[       
            'status' => 'required',     
           ];
    
        $messages = [
            'status.required' => 'Status is required.',
        ];

        $request->validate($rules, $messages);

        try{

          $reservation =  Reservation::find($id);

          $reservation->update($input);
         

          return redirect()->route('staff.reservation')->with('success', 'Status has successfully updated!!!');

        }catch(\Exception $e){
            return redirect()->route('staff.reservation')->with('error', 'Try again later');
        }

    }

    public function student_index(Request $request){
        $setting = Setting::first();

        return view('student.history.reservation_history')->with('setting', $setting);
    }

    public function api_student_index(Request $request){
      
    
        $type = $request->query('type'); 
        $studentId = auth()->user()->id;
        $today = Carbon::today();
    
      
        $reservations = Reservation::where('studentId', $studentId)
        ->when($type === 'upcoming', function ($query) use ($today) {
            return $query->where('date', '>=', $today);
        }, function ($query) use ($today) {
            return $query->where('date', '<', $today);
        })
        ->with('get_roomType')->with('get_room')
        ->get();
   
    
        return response()->json($reservations);
    }

    public function search(Request $request){

        $text = $request->query('text');
        $studentId = auth()->user()->id;

        $columns = ['time', 'date', 'status']; 

        $reservations = Reservation::where('studentId', $studentId)->where(function ($query) use ($text, $columns) {
            $query->whereHas('get_roomType', function ($subQuery) use ($text) {
                $subQuery->where('title', 'LIKE', "%$text%");
            });
    
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', "%$text%");
            }
        })->with('get_roomType')->get();
    

         return response()->json($reservations);

    }

    
   
    public function upcoming_current_booking(Request $request)
    {
       
      
        try {
                
                    $currentReservations = $this->reservationFilter->curent_reservation_hourly();
                    $currentReservations_day = $this->reservationFilter->curent_reservation_day();
                    $currentReservations_month = $this->reservationFilter->curent_reservation_month();
                    $upcomingReservation = $this->reservationFilter->reservation_hourly();
                    $reservations_month = $this->reservationFilter->reservation_montly();
                    $reservation_daily = $this->reservationFilter->reservation_daily();


                return response()->json([
                    'current' => $currentReservations ?? [],
                    'current_day' => $currentReservations_day ?? [],
                    'current_month' => $currentReservations_month ?? [],
                    'upcoming' => $upcomingReservation ? $upcomingReservation->toArray() : [],
                    'upcoming_month' => $reservations_month ?? [],
                    'upcoming_day' => $reservation_daily ? $reservation_daily->toArray() : [],
                ]);
                   
    
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }


  


    public function api_slot_year(Request $request , $id, $year){

        $reservations = Reservation::where('roomTypeId', $id)->where('date', 'LIKE', "$year-%")->get();

        $groupedReservations = $reservations->groupBy('date');

        $fullyBookedMonths = $groupedReservations->filter(function ($reservationsOnMonth) {
            $book_limit_Month = $reservationsOnMonth->first()->get_roomType->qty;
            return $reservationsOnMonth->count() >= $book_limit_Month;
        });

        $bookedMonths = $fullyBookedMonths->keys()->map(fn($month) => (int) explode('-', $month)[1]);


        $month = Carbon::today()->month;

        $MonthInYear = collect(range((int) $month + 1, 12 ));

        $allRoomIds =  Room_name::where('room_id', $id)->pluck('id');

        $availableRoomsByMonth = array();
     
    
        foreach ($MonthInYear as $key => $month) {


            if($bookedMonths->contains($month)){
                $availableRoomsByMonth[] = ['available' => false, 'month' => $month];
                continue;
            }
      
            $monthString = Carbon::create($year, $month)->format('Y-m');

           
            $reservedRoomIds = isset($groupedReservations[$monthString]) ? $groupedReservations[$monthString]->pluck('roomId') : collect([]);
        

            $availableRoomIds = $allRoomIds->diff($reservedRoomIds);

            if ($availableRoomIds->isNotEmpty()) {

                $availableRoomsByMonth[] = [
                    'available' => true,
                    'month' => $month,
                    'id' => $availableRoomIds->first(),
                ];
            }

        }

        return response()->json($availableRoomsByMonth);
    }   


    public function destroy($id){
        $reservation = Reservation::find($id);
        $reservation->delete();

        return response()->json(['success' => 'Deleted successfully']);
    }
   
}
