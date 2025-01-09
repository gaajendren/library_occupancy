<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
  
    public function index()
    {
        $reservations = Reservation::orderBy('created_at', 'desc')->get();

        return view('staff.reservation_management.index')->with('reservations', $reservations);
    }

  
    public function create()
    {
    
    }

   
    public function store(Request $request, $id)
    {
        $input = $request->all();

        $rules =[
            'img' => 'required', 
            'img.*' => 'mimes:png,jpg,jpeg,gif,svg|max:2048',
            'date' => 'required',
            'time' => 'required',
            'studentCount' => 'required|integer'
           ];
    
        $messages = [
            'img.required' => 'An image file is required.',
            'date.required' => 'The date field is required.',
            'studentCount.integer' => 'The count of student must be an integer.',
            'time.required' => 'The time field is required.'
        ];

        
        $request->validate($rules, $messages);

        try{

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
        $input['time'] = json_encode($input['time']);
        $input['studentId'] = auth()->user()->id;
        $input['roomId'] = $id;
        $input['status'] = 'pending';

       $sameDayReservation = Reservation::where('date', Carbon::today())->where('studentId', auth()->user()->id)->get();

       if($sameDayReservation){
        return redirect()->back()->with('error', 'Already reserve a room !!! Only one reservation allowed per day');
       }
    
        Reservation::create($input);

        return redirect()->route('student.dashboard')->with('success', 'Successfully Reserved !!!');


       }catch(Exception $e){

        return redirect()->back()->with('error', 'Error on reservation. Try again !!!'.$e);
       }

        
    }



    public function api_slot(Request $request, $id, $date){

      $reservations = Reservation::where('roomId', $id)->where('date', $date)->get();

      try{

        $reservationTimes = $reservations->pluck('time'); 
        $decodedTimes = $reservationTimes->map(function ($time) {
            $decodedArray = json_decode(json_decode($time), true);
            return array_map(function ($t) {
                return Carbon::createFromFormat('H:i', $t)->hour;
            }, $decodedArray);
        });

        $allTimes = $decodedTimes->flatten()->all();

       }catch(Exception $e){
        return response()->json(['error' => $e->getMessage()], 500);
       }
      
      if ($reservations->isNotEmpty()) {
        return response()->json($allTimes);
      } else {
        return response()->json([]);
      }
}


    public function show(Reservation $reservation)
    {
        //
    }

   
    public function edit(Reservation $reservation)
    {
        //
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

        }catch(Exception $e){
            return redirect()->route('staff.reservation')->with('error', 'Try again later');
        }

    }

   
    public function destroy(Reservation $reservation)
    {
        //
    }
}
