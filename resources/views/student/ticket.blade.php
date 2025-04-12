<x-app-layout>
    @include('student.partials.nav_bar')

<div class="dark bg-[#0c0f16] min-h-screen flex items-center justify-center p-4">
    <div class="relative max-w-lg w-full">
        <!-- Background effects -->
        
        <!-- Ticket Card -->
        <div id='container' class="bg-slate-100 rounded-3xl backdrop-blur-xl relative  flex flex-row  shadow-xl ">
            <!-- Left Section -->

            <div class="absolute z-20 -top-3 -left-3 p-2 bg-teal-400 hover:bg-teal-600 w-8 h-8 rounded-full shadow-lg flex justify-center items-center cursor-pointer">
                <a href="{{route('student.history')}}" class="fa-solid fa-arrow-left rounded-full p-0"></a>
            </div>

            <div class="w-4/6 flex flex-col justify-center items-start p-6 pr-10 relative ">
                <div class="text-start mb-4">
                    <h1 class="text-xl inter font-bold text-gray-900">{{ $reservation->get_roomType->title}}</h1>
                    <h2 class="text-lg inter font-bold text-gray-700">{{ $reservation->get_room->name}}</h2>
                </div>
        
                <div class="w-full pb-6">
                    <div class="flex items-center gap-2">
                        <p class="text-gray-600 text-sm whitespace-nowrap">Booking No:</p>
                        <div class="flex-1 overflow-hidden">
                            <span class="text-gray-300 text-xs tracking-widest">........................................</span>
                        </div>
                        <p class="text-gray-900 whitespace-nowrap">{{ $reservation->ticket_no}}</p>
                    </div>
        
                    <div class="flex items-center gap-2">
                        <p class="text-gray-600 text-sm whitespace-nowrap">Student Name:</p>
                        <div class="flex-1 overflow-hidden">
                            <span class="text-gray-300 text-xs tracking-widest">........................................</span>
                        </div>
                        <p class="text-gray-900 whitespace-nowrap">{{ $reservation->get_student->name }}</p>
                    </div>
                </div>
        
                <!-- Details Grid -->
                <div class="flex flex-row flex-wrap w-full gap-6 mb-6">
                    <div class="space-y-1 flex-1 min-w-[50%]">
                        <p class="text-gray-600 text-sm">When</p>
                        <p class="text-gray-900">{{ $reservation->date}}</p>
                    </div>
                    @if( $reservation->get_roomType->slot == "hour" )
                    <div class="space-y-1">
                        <p class="text-gray-600 text-sm">At</p>
                        @php  $times = json_decode(json_decode($reservation->time, true), true); @endphp
                        @php
                        $timeString = implode(', ', $times);
                        @endphp
                        <p class="text-gray-900">{{$timeString}}</p>
                    </div>
                    @endif
                </div>
        
                <!-- Price & CTA -->
                <div class="flex justify-center items-center w-full">
                    <button class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-1 rounded-3xl cabin 
                                font-medium transition-all hover:scale-[1.02] active:scale-95 border-none">
                        Print
                    </button>
                </div>
    
                <div class="absolute z-10 bottom-0 right-0 w-8 h-4 bg-[#0c0f16]"
            style="border-top-left-radius: 100px; border-top-right-radius: 100px;">
             </div>
    
             <div class="absolute z-10  top-0 right-0 w-8 h-4 bg-[#0c0f16]"
                 style="border-bottom-left-radius: 100px; border-bottom-right-radius: 100px;">
            </div>
               
            </div>
        
            <!-- Right Section -->
            <div class="relative -left-4 w-full">
                <div class="w-[calc(100%+20px)] h-full border-l border-gray-200">
                    @php  $img_array = json_decode($reservation->get_roomType->img, true);  @endphp
                    <img src="{{asset('storage/room_image/' . $img_array[0])}}" 
                    class="w-[calc(100%+20px)] h-full object-cover object-center"
                    alt="Slide 1">
                </div>
            </div>
        </div>
    </div>
</div>


</x-app-layout>