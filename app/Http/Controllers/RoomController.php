<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class RoomController extends Controller
{
     public function index()
    {
        $rooms = Room::all();

        return view('staff.room_management.index')->with('rooms' , $rooms);
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
        'quantity' => 'required|integer',
        'description' => 'required|string',
        'seat' => 'required|integer',
        'location' => 'required|string',
       ];

        $messages = [
            'title.required' => 'The title field is required.',
            'img.required' => 'An image file is required.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'description.required' => 'The description field is required.',
            'seat.required' => 'The seat field is required.',
            'seat.integer' => 'The seat value must be an integer.',
            'location.required' => 'The location field is required.',
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

       

        Room::create($input);

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

        return view('staff.room_management.edit')->with('room', $room);
    }

 
    public function update(Request $request, Room $room, $id)
    {
        $room = Room::find($id);

        $input =  $request->all();
       
        $rules =[
        
         'img' => 'required', 
         'img.*' => 'mimes:png,jpg,jpeg,gif,svg|max:2048',
         'title' => 'required|string|max:255',
         'quantity' => 'required|integer',
         'description' => 'required|string',
         'seat' => 'required|integer',
         'location' => 'required|string',
        ];
 
         $messages = [
             'title.required' => 'The title field is required.',
             'img.required' => 'An image file is required.',
             'quantity.required' => 'The quantity field is required.',
             'quantity.integer' => 'The quantity must be an integer.',
             'description.required' => 'The description field is required.',
             'seat.required' => 'The seat field is required.',
             'seat.integer' => 'The seat value must be an integer.',
             'location.required' => 'The location field is required.',
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

             $input['img'] = json_encode($filenames);
         } 
 
        $room->update($input);

        return redirect()->route('staff.room')->with('success', 'Data and images uploaded successfully!');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room, $id)
    {
        $room = Room::find($id);

        $room->delete();

        return redirect()->route('staff.room')->with('success', 'Data and images deleted successfully!');
    }
}
