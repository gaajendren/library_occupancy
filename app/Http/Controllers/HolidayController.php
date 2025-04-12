<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HolidayController extends Controller
{
   
    public function index()
    {
        return view('staff.reservation_management.holiday');
    }

    public function api_index(){

        $holidays = Holiday::all();

        $events = [];

        foreach ($holidays as $key => $holiday) {
           $events[] = [
             'title' => $holiday->reason,
             'start' => $holiday->date,
             
           
           
           ];
        }

        return response()->json($events);

    }


    public function api_index_table(){
        $holidays = Holiday::all();
        return response()->json($holidays);
    }


   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'reason' => 'required|string'
        ]);
    
       
        Holiday::create($validated);
    
        return response()->json(['success' => true]);
    }

  
    public function show(Holiday $holiday)
    {
        //
    }


    public function update(Request $request)
    {
        try {
            $id = $request->query('id');  
    
          
            $holiday = Holiday::find($id);
    
            if (!$holiday) {
                return response()->json(['error' => 'Holiday not found'], 404);
            }
    
          
            $validated = $request->validate([
                'date' => 'required|date',
                'reason' => 'required|string',
            ]);
    
          
            $holiday->update($validated);
    
      
            return response()->json(['success' => true]);
    
        } catch (Exception $e) {
          
            return response()->json(['error' => $e->getMessage()], 500);  
        }
    }
    

 
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return response()->json(['success' => true]);
    }
}
