<x-staff-app-layout>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        .category-group:not(:last-child) {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        @keyframes pulseWave {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(249, 128, 128, 0.4);
            }

            70% {
                transform: scale(1.1);
                box-shadow: 0 0 0 8px rgba(249, 128, 128, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(249, 128, 128, 0);
            }
        }

        .animate-pulse-wave {
            animation: pulseWave 2s infinite;
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.75rem;
            height: 1.75rem;
        }

        .sort-indicator {
         opacity: 0.3;
        margin-left: 5px;
    }
    .sort-indicator.active {
        opacity: 1;
        display: inline-block;
        color: #3b82f6;
    }
    </style>

    </style>

    <main class="min-h-screen bg-slate-100 py-14 max-sm:px-5">
        <!-- Messages Section -->
        <div class="mx-8 mb-6">
            @include('staff.message.success')
            @include('staff.message.error')
        </div>

        <!-- Search and Filters Section -->
        <div class="rounded-lg shadow-xs bg-white mx-8 p-6 mb-8 border border-gray-200">
            <form class="w-full md:w-2/3 mx-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>

                    <input type="text" name="search" id="search"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-black focus:border-black"
                        placeholder="Search..." required />

                    <button type="submit" id="search-btn"
                        class="text-white absolute end-2.5 bottom-2.5 bg-gray-700 hover:bg-black focus:ring-2 focus:outline-hidden font-medium rounded-lg text-sm px-4 py-2">Search</button>
                </div>
            </form>

            <!-- Filters Row -->
            <div class="flex flex-row gap-3 justify-center items-center mt-4 max-sm:hidden">
                <div class="flex items-center gap-2 border border-gray-300 rounded-lg px-2 py-0.5">
                    <span class="text-sm font-semibold text-gray-800">Room Type</span>
                    <select onselect="" id="room_typeSelection" class="bg-transparent border-none focus:ring-0 text-sm text-gray-700">
                        <option selected value="all">All</option>
                         @forelse ($room_types as $room_type)
                             <option value="{{$room_type->id}}"  data-slot="{{ $room_type->slot }}">{{$room_type->title}}</option>
                         @empty
                         <option disabled >No Room</option>
                         @endforelse
                    </select>
                </div>

                <div class="flex items-center gap-2 border border-gray-300 rounded-lg px-2 py-0.5">
                    <span class="text-sm font-semibold text-gray-800">Status</span>
                    <select id="status_selection" class="bg-transparent border-none focus:ring-0 text-sm text-gray-700">
                        @php
                            $status_config = ['pending','approved','check_in' ,'check_out' ,'complete','cancelled','rejected'];
                        @endphp
                        <option value="all" selected >All</option>
                        @foreach ($status_config as $status)
                            <option value="{{$status}}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="monthOnlySection" class="flex items-center gap-2 border border-gray-300 rounded-lg px-2 py-1 hidden">
                    <span class="text-sm font-semibold text-gray-800">Date</span>
                    <div class="relative">
                        <input id="datepicker-actions" datepicker datepicker-buttons datepicker-autoselect-today
                            type="text"
                            class="bg-white border border-none focus:ring-0  text-gray-900 text-sm rounded-lg  block max-w-36  ps-4 p-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            autocomplete='off' placeholder="Select date">
                        <svg class="w-4 h-4 absolute right-2 top-2 text-gray-600" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                </div>

                <button
                    class="text-white bg-gray-700 hover:bg-black px-4 py-2.5 h-fit text-sm font-medium rounded-lg transition-colors cursor-pointer" onclick="filter()">
                    Apply
                </button>
            </div>
        </div>

        <!-- Current & Next Booking Section -->
        <div class="mx-8 mb-8 grid grid-cols-2 gap-5">
            <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-xs">
                <h3 class="font-semibold text-gray-800 mb-3">Current Ongoing</h3>
                <div id="current" class="space-y-3">
                    <!-- Dynamic content would go here -->

                </div>
            </div>
            <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-xs">
                <h3 class="font-semibold text-gray-800 mb-5">Next Booking</h3>
                <div id="upcoming" class="space-y-4">
                    <!-- Within Next Hour -->

                </div>
            </div>
        </div>

       


        <!-- Main Reservations Table -->
        <div class="mx-8 bg-white rounded-lg shadow-lg border border-gray-300 ">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b border-gray-400 bg-gray-100 flex justify-start items-center">
                <h2 class="text-md font-semibold text-gray-900">Reservation Management</h2>
            
              
            </div>

            <!-- Table Container -->
            <div class="p-4">
                <div class="border border-gray-300 rounded-lg overflow-auto">
                    <table class="w-full ">
                        <thead class="bg-gray-100 border-b border-gray-300">
                            <tr>
                                <th class="px-5 py-3 text-sm font-semibold text-gray-800 text-center border-r border-gray-300 cursor-pointer">Ticket No</th>

                                <th class="px-5 py-3 text-sm font-semibold text-gray-800 text-center border-r border-gray-300 cursor-pointer">Room</th>
                                <th class="px-5 py-3 text-sm font-semibold text-gray-800 text-center border-r border-gray-300 cursor-pointer">Room Type</th>

                                <th
                                    class="px-5 py-3 text-sm font-semibold text-gray-800 text-center border-r border-gray-300 cursor-pointer">
                                    Student</th>
                                <th class="px-5 py-3 text-sm font-semibold text-gray-800 text-center border-r border-gray-300 cursor-pointer"
                                    data-sort="date" onclick="handleSort(this)">
                                    Date <span class="sort-indicator" data-direction="asc">↑</span>
                                    <span class="sort-indicator hidden" data-direction="desc">↓</span>
                                </th>
                                <th
                                    class="px-5 py-3 text-sm font-semibold text-gray-800 text-center border-r border-gray-300 cursor-pointer">
                                    Time Slots</th>
                                <th
                                    class="px-5 py-3 text-sm font-semibold text-gray-800 text-center border-r border-gray-300 cursor-pointer">
                                    Status</th>
                                <th class="px-5 py-3 text-sm font-semibold text-gray-800 text-center border-r border-gray-300 cursor-pointer"
                                    data-sort="studentCount" onclick="handleSort(this)">
                                    Student Count
                                    <span class="sort-indicator" data-direction="asc">↑</span>
                                    <span class="sort-indicator hidden" data-direction="desc">↓</span>
                                </th>
                                <th class="px-5 py-3 text-sm font-semibold text-gray-800 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody id="table-body" class="divide-y divide-gray-300">
                            @forelse ($reservations as $reservation)
                                <tr class="hover:bg-gray-100 transition-colors ">
                                      <td class="px-5 py-4 text-sm text-gray-700 text-center font-medium border-r border-gray-200 flex justify-center items-center gap-2">
                                         @if($reservation->status === 'pending')
                                            <div class="relative flex justify-center items-center">
                                                <span class="absolute animate-ping inline-flex h-6 w-6 rounded-full bg-red-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                            </div>
                                         @endif
                                         {{ $reservation->ticket_no}}
                                    </td>
                                    <td
                                        class="px-5 py-4 text-sm text-gray-700 text-center font-medium border-r border-gray-200">
                                        {{ $reservation->get_room?->name }}
                                    </td>
                                     <td
                                        class="px-5 py-4 text-sm text-gray-700 text-center font-medium border-r border-gray-200">
                                        {{ $reservation->get_roomType?->title }}
                                    </td>
                                    <td
                                        class="px-5 py-4 text-sm text-gray-700 text-center font-medium border-r border-gray-200">
                                        {{ $reservation->get_student?->name }}
                                    </td>
                                    <td
                                        class="px-5 py-4 text-sm text-gray-700 text-center font-medium border-r border-gray-200">
                                        {{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-5 py-4 text-center border-r border-gray-200">
                                        <div class="flex flex-wrap gap-1 justify-center">
                                            @foreach($reservation->time ? json_decode(json_decode($reservation->time, true), true) : ['Full'] as $time)
                                                <span
                                                    class="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-900 rounded-md border border-blue-300">
                                                    {{ $time }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-center border-r border-gray-200">
                                        @php
                                         $statusConfig = [
                                                'pending' => 'bg-yellow-100 text-yellow-900 border-yellow-300',
                                                'check_in' => 'bg-blue-100 text-blue-900 border-blue-300',
                                                'check_out' => 'bg-purple-100 text-purple-900 border-purple-300',
                                                'approved' => 'bg-indigo-100 text-indigo-900 border-indigo-300',
                                                'complete' => 'bg-green-100 text-green-900 border-green-300',
                                                'cancelled' => 'bg-red-100 text-red-900 border-red-300',
                                                'rejected' => 'bg-gray-100 text-gray-900 border-gray-300',
                                            ];
                                        @endphp
                                        <span
                                            class="px-3 py-1 text-xs font-medium rounded-full border {{ $statusConfig[$reservation->status] ?? 'bg-gray-100' }}">
                                            {{ ucfirst($reservation->status) }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-5 py-4 text-sm text-gray-800 text-center font-medium border-r border-gray-200">
                                        {{ $reservation->studentCount }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                          <form method="get" action="{{route('staff.show.reservation', $reservation->id)}}" >
                                            @csrf
                                                <button type="submit"
                                                    class="p-2 text-gray-700 hover:text-gray-900 rounded-md hover:bg-gray-200 transition-colors cursor-pointer">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <button
                                                class="p-2 text-blue-700 hover:text-blue-900 rounded-md hover:bg-blue-100 transition-colors cursor-pointer" data-modal-target="reservation-modal" data-modal-toggle="reservation-modal" onclick="data_set(this)" data-id="{{ $reservation->id }}" data-status="{{ $reservation->status }}"> 
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-6 text-center text-sm text-gray-500">
                                        No reservations found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex items-center justify-between border-t border-gray-300 pt-4">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <a href="#"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </a>
                        <a href="#"
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </a>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">1</span>
                                to
                                <span class="font-medium">10</span>
                                of
                                <span class="font-medium">97</span>
                                results
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-xs -space-x-px"
                                aria-label="Pagination">
                                <a href="#"
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    1
                                </a>
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    2
                                </a>
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    3
                                </a>
                                <span
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                    ...
                                </span>
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    8
                                </a>
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    

     <button id="btn_modal" data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="hidden" type="button"></button>

    <div id="reservation-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-[100%] ">
       
        <div class="relative p-4 w-full sm:max-w-md md:max-w-lg  max-w-md  max-h-full my-10">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b-[1px] rounded-t dark:border-gray-600">
                    <h3 class="title text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Status
                    </h3>
                    <button type="button" onclick="reset()" 
                        class="text-gray-400 cursor-pointer bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="reservation-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                            <label for="status"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select id="status" name="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach ($status_config as $status)
                                 <option  value="{{$status}}">{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>

                            @error('status')
                                <div class="text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" onclick="submit_form()" id='submit'
                            class="text-white cursor-pointer bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-hidden focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mb-2">Submit</button>
                    </form>
                </div>


            </div>
        </div>
    </div>
  
    @include('staff.reservation_management.modal')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script>
        document.getElementById('room_typeSelection').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const slot = selectedOption.getAttribute('data-slot');
            const monthSection = document.getElementById('monthOnlySection');
            const inputdate = document.getElementById('datepicker-actions');

            if (slot === 'month') {
                monthSection.classList.add('hidden');
                inputdate.value = '';
            } else {
                monthSection.classList.remove('hidden');
                inputdate.value = ''
            }
        });

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

        document.addEventListener('DOMContentLoaded', (event) => {
            getUpcoming_current_Booking()
        })

        async function getUpcoming_current_Booking() {
            try {
                const response = await axios.get('/upcoming_current_booking');

                console.log(response.data)



                struct_upcoming_current(response.data)




            } catch (error) {
                console.log(error);
            }


            function struct_upcoming_current(response) {

                let current_container = document.getElementById('current');
                let container = document.getElementById('upcoming');

                

                create_body('bg-blue-50', 'Within Next Hour', response.upcoming[0], container, 'hour',  response.upcoming)
              
                create_body('bg-green-50', 'Next Month (By Month)', response.upcoming_month[0], container, 'month' ,response.upcoming_month)

                create_body('bg-orange-50', 'By Day', response.upcoming_day[0], container, 'day' ,response.upcoming_day)

                create_body('bg-blue-50', 'Current On Going Hour', response.current[0], current_container, 'hour' ,  response.current)


                create_body('bg-green-50', 'Current Day Booking', response.current_day[0], current_container, 'day' , response.current_day)

                create_body('bg-orange-50', 'Current Month Booking', response.current_month[0], current_container, 'month' , response.current_month)
            }

        }


        function create_body(bg, header_text, e, container, category, reservation) {


            if (!e || e.length < 1) {
                return;
            }

            const parent_container = document.createElement("div");
            parent_container.classList.add('category-group');

            const div = document.createElement("div");
            const main_container = document.createElement('div');

            main_container.classList.add('space-y-2');

            div.classList.add('p-3', bg, 'rounded-lg', 'mb-2');

            const flexDiv = document.createElement("div");
            flexDiv.classList.add('flex', 'justify-between', 'items-center');


            const infoDiv = document.createElement("div");
            const roomSpan = document.createElement("span");
            roomSpan.classList.add('text-sm', 'font-medium', 'text-gray-900');
            roomSpan.textContent = e.get_room.name;

            const userSpan = document.createElement("span");
            userSpan.classList.add('text-sm', 'text-gray-600', 'ml-2');

            const ticketSpan = document.createElement("span");
            ticketSpan.classList.add('text-sm', 'text-gray-600', 'ml-2');

            userSpan.textContent = e.get_student.name.substring(0, 10);
            ticketSpan.textContent = e.ticket_no;

            infoDiv.appendChild(roomSpan);
            infoDiv.appendChild(userSpan);
            infoDiv.appendChild(ticketSpan);


            const statusDiv = document.createElement("div");
            statusDiv.classList.add('flex', 'items-center', 'gap-2');

            const dateBadge = document.createElement("span");
            dateBadge.classList.add('text-xs', 'font-medium', 'px-2', 'py-1', 'bg-white', 'text-blue-600', 'rounded-full');
            dateBadge.textContent = formatDate(e.date);

            const timeBadge = document.createElement("span");

            if (category == 'hour') {
                timeBadge.classList.add('text-xs', 'font-medium', 'px-2', 'py-1', 'bg-white', 'text-orange-600', 'rounded-full');
                timeBadge.textContent = formatTime(e.selected_time);
            }

            const statusBadge = document.createElement("span");
            statusBadge.classList.add('text-xs', 'font-medium', 'px-2', 'py-1', 'bg-yellow-100', 'text-yellow-800', 'rounded-full');
            statusBadge.textContent = e.status;

            statusDiv.appendChild(dateBadge);

            if (category == 'hour') {
                statusDiv.appendChild(timeBadge);
            }

            statusDiv.appendChild(statusBadge);

            if (e.same_time_count > 1) {
                const countBadge = document.createElement("button");
                countBadge.classList.add('text-xs', 'font-medium', 'cursor-pointer' ,'px-2', 'py-1', 'rounded-full', 'border', 'border-red-100', 'bg-red-100', 'animate-pulse-wave', 'cursor-pointer');
                countBadge.textContent = e.same_time_count;
                countBadge.addEventListener('click', ()=>{
                    document.getElementById('btn_modal').click();
                    modal_dataUpdate(reservation,category,header_text, bg);
                });
                statusDiv.appendChild(countBadge);
            }

            flexDiv.appendChild(infoDiv);
            flexDiv.appendChild(statusDiv);
            div.appendChild(flexDiv);



            const existingHeader = container.querySelector(`#next-${category}-header`);
            if (!existingHeader) {
                const header = document.createElement('h4');
                header.id = `next-${category}-header`;
                header.className = 'text-xs font-semibold text-gray-500 uppercase mb-2';
                header.textContent = header_text;
                parent_container.appendChild(header);
            }

            main_container.appendChild(div)
            parent_container.appendChild(main_container);

            container.appendChild(parent_container)
        }

        function modal_dataUpdate(reservation, category ,header_text, bg){

           document.getElementById('modal_container').innerHTML = '';

            reservation.forEach((e)=>{
                    

                    let html = '<div class="category-group">';

                    if (!document.querySelector(`#next-${category}-header`)) {
                        html += `<h4 id="next-${category}-header" class="text-xs font-semibold text-gray-500 uppercase mb-2">${header_text}</h4>`;
                    }

                    html += `
                        <div class="space-y-2">
                            <div class="p-3 ${bg} rounded-lg mb-2">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">${e.get_room.name}</span>
                                        <span class="text-sm text-gray-600 ml-2">${e.get_student.name.substring(0, 10)}</span>
                                         <span class="text-sm text-gray-600 ml-2">${e.ticket_no}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-medium px-2 py-1 bg-white text-blue-600 rounded-full">${formatDate(e.date)}</span>
                    `;

                    if (category === 'hour') {
                        html += `<span class="text-xs font-medium px-2 py-1 bg-white text-orange-600 rounded-full">${formatTime(e.selected_time)}</span>`;
                    }

                    html += `<span class="text-xs font-medium px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">${e.status}</span>`;

                    html += `
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;

                   
                    document.getElementById('modal_container').innerHTML  += html;

            })
            
           
        }

        function formatTime(timeString) {

            const [hours, minutes] = timeString.split(":");
            const formattedTime = new Date(0, 0, 0, hours, minutes)
                .toLocaleTimeString("en-US", {
                    hour: "2-digit",
                    minute: "2-digit",
                    hour12: true,
                });

            return formattedTime;
        }

        function formatDate(dateString) {
            const dateObj = new Date(dateString);
            const formattedDate = dateObj.toLocaleDateString("en-US", {
                month: "short",
                day: "2-digit",
                year: "numeric",
            });
            return formattedDate;
        }



        document.getElementById("search-btn").addEventListener("click", function (event) {
            event.preventDefault();
            let searchValue = document.getElementById("search").value;
            if (searchValue) {
                let searchUrl = "{{ route('staff.reservation.search') }}?search=" + encodeURIComponent(searchValue);
                window.location.href = searchUrl;
            }else{
                window.location.href = "{{ route('staff.reservation') }}";
            }
        });


        let currentSort = null;

        async function handleSort(header) {
            const column = header.dataset.sort;
            const indicators = header.querySelectorAll('.sort-indicator');
            
            let direction = 'asc';

            if (currentSort?.column === column) {
                direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            }
            
            currentSort = { column, direction };

            document.querySelectorAll('.sort-indicator').forEach(indicator => {
                indicator.classList.remove('active');
            });
            indicators.forEach(indicator => {
                if (indicator.dataset.direction === direction) {
                    indicator.classList.add('active');
                }
            });

            try {
                const response = await axios.get('/staff/api/reservation/sort', {
                    params: {
                        sort_by: column,
                        sort_dir: direction
                    }
                });
                
                renderTableBody(response.data.reservations);
            } catch (error) {
                console.error('Error sorting data:', error);
                alert('Error sorting data. Please try again.');
            }
        }

        

        function renderTableBody(reservations) {
            const tbody = document.getElementById('table-body');
            
            if (reservations.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-5 py-6 text-center text-sm text-gray-500">
                            No reservations found
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = reservations.map(reservation => `
                <tr class="hover:bg-gray-100 transition-colors">
                    <td class="px-5 py-4 text-sm text-gray-700 text-center font-medium border-r border-gray-200">
                        ${reservation.ticket_no || ''}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700 text-center font-medium border-r border-gray-200">
                        ${reservation.get_room?.name || ''}
                    </td>
                     <td class="px-5 py-4 text-sm text-gray-700 text-center font-medium border-r border-gray-200">
                        ${reservation.get_roomType?.title || ''}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700 text-center font-medium border-r border-gray-200">
                        ${reservation.get_student?.name || ''}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700 text-center font-medium border-r border-gray-200">
                        ${new Date(reservation.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                    </td>
                    <td class="px-5 py-4 text-center border-r border-gray-200">
                        <div class="flex flex-wrap gap-1 justify-center">
                            ${getTimeSlotsHtml(reservation.time)}
                        </div>
                    </td>
                    <td class="px-5 py-4 text-center border-r border-gray-200">
                        ${getStatusHtml(reservation.status)}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-800 text-center font-medium border-r border-gray-200">
                        ${reservation.studentCount}
                    </td>
                    <td class="px-5 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <form method="get" action="/reservation/show/${reservation.id}" >
                                @csrf
                                <button class="p-2 text-gray-700 hover:text-gray-900 rounded-md hover:bg-gray-200 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                    </svg>
                                </button>
                            </form>
                            <button class="p-2 text-blue-700 hover:text-blue-900 rounded-md hover:bg-blue-100 transition-colors" data-modal-target="reservation-modal" data-modal-toggle="reservation-modal" onclick="data_set(this)" data-id="${reservation.id}" data-status="${reservation.status}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

       
        function getTimeSlotsHtml(time) {
            if (!time) return '<span class="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-900 rounded-md border border-blue-300">Full</span>';
            
            try {
                const times = JSON.parse(time);
                const decodedTimes = typeof times === 'string' ? JSON.parse(times) : times;
                const timeArray = Array.isArray(decodedTimes) ? decodedTimes : ['Full'];
                
                return timeArray.map(t => `
                    <span class="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-900 rounded-md border border-blue-300">
                        ${t}
                    </span>
                `).join('');
            } catch (e) {
                return '<span class="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-900 rounded-md border border-blue-300">Full</span>';
            }
        }

        
        function getStatusHtml(status) {
            const statusConfig = {
                'pending': 'bg-yellow-100 text-yellow-900 border-yellow-300',
                'check_out': 'bg-purple-100 text-purple-900 border-purple-300',
                'complete': 'bg-green-100 text-green-900 border-green-300',
                'cancelled': 'bg-red-100 text-red-900 border-red-300',
                'rejected': 'bg-gray-100 text-gray-900 border-gray-300'
            };
            
            const classes = statusConfig[status] || 'bg-gray-100';
            
            return `
                <span class="px-3 py-1 text-xs font-medium rounded-full border ${classes}">
                    ${status.charAt(0).toUpperCase() + status.slice(1)}
                </span>
            `;
}

    async function filter(){

       let date = document.getElementById('datepicker-actions').value;

       const room_type = document.getElementById('room_typeSelection').value;

       const status = document.getElementById('status_selection').value;

       if(!date){date = 'all'}

        console.log(date)

        const response = await axios.get('/staff/api/reservation/filter', {
                            params:{
                                    date: date,
                                    room_type: room_type,
                                    status: status
                                }
                        });

                        renderTableBody(response.data.reservations);
    }

    </script>
</x-staff-app-layout>