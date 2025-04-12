<?php

namespace App\Http\Controllers;

use App\Models\Room_name;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomNameController extends Controller
{
    
    public function index($id)
    {
       $room_names = Room_name::where('room_id', $id)->get();

       return response()->json($room_names);
    }

  
    public function store(Request $request, $id)
    {

        try{
            $input = $request->all();

            $input['room_id'] = $id;

            $room_type = Room::find($id);

            if ($room_type) {
                $room_type->qty += 1;
                $room_type->save(); 
            }

            Room_name::create($input);

            

            return response()->json(['success' => true]);

        }catch(Exception $e){
             return response()->json(['success' => false]);
        }
 
    }

   
    public function show(Room_name $room_name)
    {
        
    }

  
    public function edit(Room_name $room_name)
    {
        
    }

   
    public function update(Request $request)
    {
        $rooms = $request->input('rooms');

        foreach ($rooms as $room) {
            Room_name::where('id', $room['id'])->update([
                'name' => $room['name'],
                'location' => $room['location']
            ]);
        }

        
        return response()->json(['message' => 'Rooms updated successfully!']);
    }
        
    

   
    public function destroy(Room_name $room_name, $id)
    {
        try{
            Room_name::find($id)->delete();

            $room_type = Room::find($id);

            if ($room_type) {
                $room_type->qty -= 1;
                $room_type->save(); 
            }

            return response()->json(['success' => true]);
        }catch(Exception $e){
            return response()->json(['success' => false]);

        }
       

    }
}
