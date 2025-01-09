<x-staff-app-layout>

    <main class="h-screen bg-slate-200 py-14 max-sm: px-5" > 
        @include('staff.message.success')
        @include('staff.message.error')
        <div class="flex flex-col  p-4 mx-8 bg-white shadow-[0px_5px_30px_20px_rgba(0,0,0,0.1)] rounded-lg mb-10">
            <a id='addRoom' href=''  class="bg-blue-500 self-end rounded-lg shadow-md float-end p-3 py-2 text-white hover:bg-blue-700">Add Reservation</a>
    
            <div class=" p-1 mx-2 table-container bg-white dark:bg-gray-800 dark:text-white ">
                <table id='table' class="w-full  mt-10 text-sm text-left border-collapse border border-1 border-gray-300 rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 border  max-w-[200px] border-gray-300">
                               Room Name
                            </th>
                           <th scope="col" class="px-6 py-3 border  border-gray-300">
                               Student Name
                            </th>
                            <th scope="col" class="px-6 py-3 border  border-gray-300">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 border  border-gray-300">
                                Time
                            </th>
                            <th scope="col" class="px-6 py-3 border  border-gray-300">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 border  border-gray-300">
                                Total Student
                            </th>
                            <th scope="col" class="px-6 py-3 border  border-gray-300">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class='overflow-x-auto'>
    
                        @foreach ( $reservations as $reservation)
                        <tr class="bg-white  h-full w-screen dark:bg-gray-800 dark:border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                            
                            <td  class=" px-1 py-4  font-medium border border-gray-300 ">
                                {{$reservation->get_room?->title}}
                            </td>
                            <td  class=" px-1 py-4  font-medium border border-gray-300 ">
                                {{$reservation->get_student?->name}}
                            </td>
                            <td class=" px-6  py-4 border  border-gray-300">
                                {{$reservation->date}}
                            </td>
                            <td class="px-6  py-4 border  border-gray-300">
                                @php
                                    
                                    $times = json_decode(json_decode($reservation->time), true);
                                   
                                @endphp
                            
                                {{ implode(', ', $times) ?: 'No times available' }}
                            </td>
                            <td class=" px-6  py-4 border  border-gray-300">
                                @php
                                    $status = $reservation->status;

                                     if($status == 'pending'){
                                        $status = 'Pending';
                                        $color = 'bg-blue-400';                                       
                                     }else if($status == 'check_out'){
                                        $status = 'Check out';
                                        $color = 'bg-yellow-400';
                                     }else if($status == 'complete'){
                                        $status = 'Complete';
                                        $color = 'bg-green-400';
                                     }else if($status == 'cancelled'){
                                        $status = 'Cancelled';
                                        $color = 'bg-red-400';
                                     }
                                   
                                @endphp
                                
                                <a class="rounded-lg px-3 py-2 text-white {{$color}}">{{$status}}</a>
                            </td>
                            <td class=" px-6  py-4 border  border-gray-300">
                                {{$reservation->studentCount}}
                            </td>

                            <td class="px-6 py-4  border border-gray-300 ">
                                <div class="flex flex-row justify-center items-center gap-2">
                                    <a href="" class="block text-white bg-blue-500 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center " type="button">
                                        <i class="fa-solid fa-eye fa-sm"></i>
                                    </a>
                                    <button onclick="data_set(this)" data-modal-target="reservation-modal" data-action='edit' data-id='{{$reservation->id}}' data-status="{{$reservation->status}}" data-modal-toggle="reservation-modal" class="block text-white bg-green-500 hover:bg-green-800 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center " type="button">
                                        <i class="fa-solid fa-pen-to-square fa-sm"></i>
                                    </button>
                                    <form method="POST" action="" accept-charset="UTF-8" >
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="block text-white bg-red-500 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center " onclick="return confirm(&quot;Confirm delete?&quot;)">
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
    
    

    <div id="reservation-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-[100%] ">
        <div class="absolute top-0 left-0 bg-gray-700 w-full min-h-[120%] h-full opacity-60" style="bottom: auto;"></div>
        <div class="relative p-4 w-full sm:max-w-md md:max-w-lg  max-w-md  max-h-full my-10">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="title text-xl font-semibold text-gray-900 dark:text-white">
                     
                    </h3>
                    <button  type="button" onclick="reset()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="reservation-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-4 space-y-5">
                    <form method="post" action="" id='form' class="max-w-sm mx-auto">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-5">
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="pending">Pending</option>
                                <option value="check_out">Check out</option>
                                <option value="complete">Complete</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
    
                            @error('status')
                            <div class="text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" onclick="submit_form()" id='submit' class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mb-2">Submit</button>
                    </form>
                </div>
            
               
            </div>
        </div>
    </div>
    
<script>
 function data_set(e) {
   
    const id = e.getAttribute('data-id');
    const status = e.getAttribute('data-status');
    
   
    const form = document.getElementById('form');
    form.action = `/staff/reservation/update/${id}`;

   
    console.log(form.action);

   
    const statusElement = document.getElementById('status');
    statusElement.value = status;
    console.log(statusElement.value)
}

function submit_form() {
    const form = document.getElementById('form');
    form.submit(); 
}


</script>
</x-staff-app-layout>