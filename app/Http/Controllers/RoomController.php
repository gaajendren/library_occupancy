<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Holiday;
use App\Models\Room;
use App\Models\Room_name;
use App\Models\Reservation;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class RoomController extends Controller
{
     public function index()
    {
        $rooms = Room::all();
        

        return view('staff.room_management.index')->with('rooms' , $rooms);
    }


    public function index_api()
    {
        $rooms = Room::all();

        if ($rooms->isEmpty()) {
            return response()->json([
                'message' => 'No rooms found.',
                'rooms' => [],
            ], 404);
        }
    
        return response()->json($rooms, 200);
    }

   
    public function create()
    {
        return view('staff.room_management.add');
    }

  
    public function store(Request $request)
    {
       $input =  $request->all();
       
       $rules =[
       
        'img' => 'required', 
        'img.*' => 'mimes:png,jpg,jpeg,gif,svg|max:2048',
        'title' => 'required|string|max:255',
        'slot' => 'required|string',
        'max_slot' => 'required|string',
        'description' => 'required|string',
        'max_seat' => 'required|string',
        'min_seat' => 'required|string',
        'qnty' => 'required|string',
       
       ];

        $messages = [
            'title.required' => 'The title field is required.',
            'img.required' => 'An image file is required.',
            'slot.required' => 'The slot field is required.',
            'max_slot.required' => 'This field is required.',
            'description.required' => 'The description field is required.',
            'min_seat.required' => 'The seat field is required.',
            'max_seat.required' => 'The seat field is required.',
            'qnty.required' => 'The quantity field is required.',
           
        ];

        
        $request->validate($rules, $messages);

       
        $filenames = array();

        if ($request->hasFile('img')) {
            
            foreach ($request->file('img') as $image) {
                
                $filename = $image->getClientOriginalName();
                $uniqueFilename = time() . '_' . $filename; 
                $image->storeAs('room_image', $uniqueFilename, 'public');
                $filenames[] = $uniqueFilename;
            }
        } else {
            dd('No files found');
        }

        $input['img'] = json_encode($filenames);

       
        $input['qty']  = $input['qnty'];


        $room = Room::create($input);


        foreach ($input['room_names'] as $key => $room_name) {
            $room_input = array();

            $room_input['name'] = $room_name;
            $room_input['room_id'] = $room->id;
            
            Room_name::create($room_input);
        }


        return redirect()->route('staff.room')->with('success', 'Data and images uploaded successfully!');

    }

   
    public function show(Room $room, $id)
    {
        $room =  Room::find($id);

        return view('staff.room_management.view')->with('room', $room);


    }

    public function edit(Room $room, $id)
    {
        $room =  Room::find($id);

        $room_names =  Room_name::where('room_id', $id);

        return view('staff.room_management.edit')->with('room', $room)->with('room_names', $room_names);
    }

 
    public function update(Request $request, $id)
    {
        $room = Room::find($id);

        $input =  $request->all();
       
        $rules =[
    
         'title' => 'required|string|max:255',
         'description' => 'required|string',
         'max_seat' => 'required|string',
         'min_seat' => 'required|string',
         'slot' => 'required|string',
         'max_slot' => 'required|string',
       
       
        ];
 
         $messages = [
             'title.required' => 'The title field is required.',
          
             'description.required' => 'The description field is required.',
             'min_seat.required' => 'The seat field is required.',
             'max_seat.required' => 'The seat field is required.',
             'slot.required' => 'The slot field is required.',
             'max_slot.required' => 'This field is required.',
         ];
 
         
         $request->validate($rules, $messages);
 
         try{ 
            $filenames = array();
    
            if ($request->hasFile('img')) {
                
                foreach ($request->file('img') as $image) {
                    
                    $filename = $image->getClientOriginalName();
                    $uniqueFilename = time() . '_' . $filename; 
                    $image->storeAs('room_image', $uniqueFilename, 'public');
                    $filenames[] = $uniqueFilename;
                }

                $input['img'] = json_encode($filenames);
            } 
     

        }catch(Exception $e){
            return redirect()->route('staff.room')->with('error', $e);
         }
 
        $room->update($input);

        return redirect()->route('staff.room')->with('success', 'Room Data updated successfully!');
    }
   
    public function destroy(Room $room, $id)
    {
        $room = Room::find($id);

        Room_name::where('room_id', $id)->delete();
       
        $room->delete();

        return redirect()->route('staff.room')->with('success', 'Data and images deleted successfully!');
    }

    function student_show($id){
        $room = Room::find($id);

        if(!$room){
            session()->flash('error', "This room type already removed");
            return view('student.history.reservation_history');
        }
        return view('student.room.view_room')->with('room', $room);
    }

    function api_dateSlot($id,$month){

        try{

        $selectedMonth = $month;
        $currentYear = Carbon::now()->year;

        $reservations = Reservation::where('roomTypeId', $id)->with('get_room')->with('get_roomType')->whereYear('date', $currentYear)->whereMonth('date', $selectedMonth)->whereDate('date', '>=', Carbon::today()->toDateString())->get();


        $groupedReservations = $reservations->groupBy(function($reservation) {
            return Carbon::parse($reservation->date)->format('Y-m-d');
        });
       
      
        $fullyBookedDays = $groupedReservations->filter(function ($reservationsOnDay) {
            $book_limit_day = $reservationsOnDay->first()->get_roomType->qty;
            return $reservationsOnDay->count() >= $book_limit_day;
        });

        $bookedDays = $fullyBookedDays->keys()->map(fn($date) => Carbon::parse($date)->day);


        $today = Carbon::today()->day;
        $daysInMonth = collect(range($today, Carbon::create($currentYear, $selectedMonth)->daysInMonth));

      

        $allRoomIds =  Room_name::where('room_id', $id)->pluck('id');

        $availableRoomsByDate = array();
     
    
        foreach ($daysInMonth as $key => $day) {

          
            if($bookedDays->contains($day)){
                $availableRoomsByDate[] = ['available' => false, 'date' => $day];
                continue;
            }
      
            $dateString = Carbon::create($currentYear, $selectedMonth, $day)->format('Y-m-d');

           
            $reservedRoomIds = isset($groupedReservations[$dateString]) ? $groupedReservations[$dateString]->pluck('roomId') : collect([]);
        

            $availableRoomIds = $allRoomIds->diff($reservedRoomIds);

            if ($availableRoomIds->isNotEmpty()) {

                $availableRoomsByDate[] = [
                    'available' => true,
                    'date' => $day,
                    'id' => $availableRoomIds->first(),
                ];
            }

        

        }

      
        return response()->json($availableRoomsByDate);

        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }


    


}
