<x-staff-app-layout>
    <div class='dark flex flex-col min-h-screen bg-slate-200'>
        <div class="mx-auto  montserrat-regular text-2xl tracking-wider text-slate-700" >
            <h1 class="text-center pt-[50px]">Show Room</h1>
        </div>
        <div class="max-w-screen-lg w-3/4 mx-auto">
            <div class=" mx-auto md:gap-10 sm:gap-6 gap-4 md:m-[3rem] sm:m-[2rem] m-[1rem]">
                <div class="w-full bg-white rounded-xl mx-auto shadow-lg p-5">
                        
                        <label class="text-slate-600" for="img">Image</label>
                        <div class="flex flex-col mt-4 text-slate-300 mb-3">
                                @php
                                $image_array = json_decode($room->img);

                               
                                if($image_array){
                                    echo '<span class="flex flex-row gap-3">';
                                        $count = 0;
                                    foreach ($image_array as $img ) {
                                        $count = $count + 1;
                                        echo '<div class="relative"><img  class="inline max-w-[120px] aspect-square" src="' . asset('storage/room_image/' . $img) . '" alt=""> </div>';
                                    }
                                    echo '</span>';
                                    
                                }
                                    
                                @endphp   
                        </div>
    
                      
                        <div class="pt-8 flex flex-col items-start justify-center text-slate-600 mb-3"> 
                            <label for="title" class="mb-3 ">Title: {{$room->title}}</label>
                          
                        </div>
                    
                       
                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="quantity" class="mb-3 ">Quantity:{{$room->quantity}}</label>
                            
                          
                        </div>

                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="seat" class="mb-3 ">Seat:{{$room->seat}}</label>
                           
                          
                        </div>

                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="location" class="mb-3 ">Location:{{$room->location}}</label>
                           
                           
                        </div>

                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="desc" class="mb-3 ">Description:{{$room->description}}</label>
                            
                         
                        </div>
                </div>
            </div>
        </div>
       
    </div>
   

</x-staff-app-layout>
