<x-staff-app-layout>

    <main class="min-h-screen bg-slate-200 py-14 max-sm: px-5" > 
        @include('staff.message.success')
        @include('staff.message.error')
        <div class="flex flex-col  p-4 mx-8 bg-white shadow-[0px_5px_30px_20px_rgba(0,0,0,0.1)] rounded-lg mb-10">
            <a id='addRoom' href='{{route('staff.add.room')}}'  class="bg-blue-500 self-end rounded-lg shadow-md float-end p-3 py-2 text-white hover:bg-blue-700">Add Room</a>
    
            <div class=" p-1 mx-2 table-container bg-white dark:bg-gray-800 dark:text-white ">
                <table id='table' class="w-full  mt-10 text-sm text-left border-collapse border border-1 border-gray-300 rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                        
                            <th scope="col" class="px-6 py-3 border  max-w-[200px] border-gray-300">
                               Img
                            </th>
                            <th scope="col" class="px-6 py-3 border  border-gray-300">
                                Room Name
                            </th>
                           <th scope="col" class="px-6 py-3 border  border-gray-300">
                                Seat
                            </th>
                            <th scope="col" class="px-6 py-3 border  border-gray-300">
                               Slot
                            </th>
                            <th scope="col" class="px-6 py-3 border  border-gray-300">
                                Max Slot
                             </th>
                             <th scope="col" class="px-6 py-3 border  border-gray-300">
                                Quantity
                             </th>
                            <th scope="col" class="px-6 py-3 border  border-gray-300">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class='overflow-x-auto'>
    
                        @foreach ( $rooms as $room)
                        <tr class="bg-white  h-full w-screen dark:bg-gray-800 dark:border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                            
                            <td  class=" px-1 py-4  font-medium border border-gray-300 ">
                                @php
                                   $img_array = json_decode($room->img, true); 

                                   if($img_array) {                            
                                       echo  '<img class="max-w-[200px]   mx-auto object-cover border-none" src="' . asset('storage/room_image/' . $img_array[0]) . '" alt="Room Image">';
                                   }
                                @endphp
                            </td>
                            <td class=" px-6  py-4 border  border-gray-300">
                                {{$room->title}}
                            </td>
                            <td class="px-6  py-4 border  border-gray-300">
                                {{$room->min_seat}} - {{$room->max_seat}}
                            </td>
                            <td class="px-6  py-4 border  border-gray-300">
                                {{Str::title($room->slot)}} 
                            </td>
                            <td class="px-6  py-4 border  border-gray-300">
                                {{$room->max_slot}}
                            </td>
                            <td class="px-6  py-4 border  border-gray-300">
                                {{$room->qty}}
                            </td>

                            <td class="px-6 py-4  border border-gray-300 ">
                                <div class="flex flex-row justify-center items-center gap-2">
                                    <a href="{{route('staff.show.room', $room->id)}}" class="block text-white bg-blue-500 hover:bg-blue-800 focus:ring-2 focus:outline-hidden focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center " type="button">
                                        <i class="fa-solid fa-eye fa-sm"></i>
                                    </a>
                                    <a  data-modal-target="edit-room" id="editRoom" onclick="load_roomNames({{$room->id}})" data-id="{{$room->id}}" data-modal-toggle="edit-room" class="block text-white bg-yellow-500 hover:bg-yellow-800 focus:ring-2 focus:outline-hidden focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center cursor-pointer" type="button">
                                        <i class="fa-solid fa-file-contract fa-sm"></i>
                                    </a>
                                    <a href="{{route('staff.edit.room', $room->id)}}"   class="block text-white bg-green-500 hover:bg-green-800 focus:ring-2 focus:outline-hidden focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center " type="button">
                                        <i class="fa-solid fa-pen-to-square fa-sm"></i>
                                    </a>
                                    <form method="POST" action="{{route('staff.delete.room', $room->id)}}" accept-charset="UTF-8" >
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="block text-white bg-red-500 hover:bg-red-800 focus:ring-2 focus:outline-hidden focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center " onclick="return confirm(&quot;Confirm delete?&quot;)">
                                           <i class="fa-solid fa-trash-can fa-sm"></i>
                                        </button>
                                    </form>
                                
                                </div>
                            
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>  

    @include('staff.room_management.modal');
</x-staff-app-layout>