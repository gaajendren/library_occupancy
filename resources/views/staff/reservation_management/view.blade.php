<x-staff-app-layout>
  
    <div class="p-4 max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            {{-- Header Section --}}
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">Reservation Details</h1>
                        <p class="text-sm text-gray-600 mt-1">Ticket #{{ $reservation->ticket_no }}</p>
                    </div>
                    <a href="{{ route('staff.reservation') }}" 
                    class="text-gray-600 hover:text-gray-900 flex items-center gap-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Left Column --}}
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Student Name</label>
                            <p class="text-gray-900">{{ $reservation->get_student?->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Room Details</label>
                            <p class="text-gray-900">
                                {{ $reservation->get_room?->name }} 
                                ({{ $reservation->get_roomType?->title }})
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Date & Time</label>
                            <p class="text-gray-900">
                                {{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}
                                <span class="mx-2 text-gray-400">|</span>
                                <span class="inline-flex flex-wrap gap-1">
                                    @foreach($reservation->time ? json_decode(json_decode($reservation->time, true), true) : ['Full'] as $time)
                                    <span class="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-md">
                                        {{ $time }}
                                    </span>
                                    @endforeach
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'check_out' => 'bg-purple-100 text-purple-800',
                                    'complete' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    'rejected' => 'bg-gray-100 text-gray-800'
                                ];
                            @endphp
                            <span class="px-3 py-1.5 text-sm font-medium rounded-full {{ $statusColors[$reservation->status] ?? 'bg-gray-100' }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Student Count</label>
                            <p class="text-gray-900">{{ $reservation->studentCount }}</p>
                        </div>

                        <div>
                           <label class="block text-sm font-medium text-gray-500 mb-1">Slot</label>
                            <p class="text-gray-900">{{ ucfirst($reservation->get_roomType?->slot) }}</p>
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-center items-center pt-5">
                    <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="flex flex-row justify-center items-center cursor-pointer bg-black hover:bg-black/50 rounded-lg shadow-md p-2 py-1.5 gap-2 text-sm text-white "><i class="fa-solid fa-eye fa-sm "></i>View Matrix Card</button>
                </div>
            </div>

        
        </div>
    </div>


    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-10">
                        @foreach ( json_decode($reservation->matric_pic) as $pic)

                       <img class="object-cover w-full aspect-square" src="{{ asset('/storage/student_matrix/' . $pic) }}" alt="">

                        
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-staff-app-layout>