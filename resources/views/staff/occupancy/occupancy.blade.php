<x-staff-app-layout>
  
    <div class="h-full w-full bg-slate-200 contains">
        <header class="text-slate-800 pt-10 font-semibold text-xl tracking-wider text-center w-full">Person</header>



        <div class="flex flex-row flex-wrap sm:gap-2 md:gap-5 gap-5 justify-center items-center w-full p-8">
            <div id="bg" class="absolute inset-0 w-full  bg-black bg-opacity-80 hidden z-10"></div>
            @foreach ($person as $item)
                
                <div class="w-[17%] max-w-[140px] min-w-[90px] h-[250px] bg-white rounded-xl shadow-sm aspect-auto overflow-hidden cursor-pointer " onclick="checker(event)" >
                    <img src="http://127.0.0.1:5000/person_img/{{$item->img}}" alt="img" class=" w-full h-full  object-fill object-center">
                    <div aria-hidden="true"  class="absolute inset-0 top-0  flex justify-center items-center w-full h-full  aspect-auto overflow-hidden hidden modalView z-20">
                       
                        @if ($item->personExit)
                        <div class="rounded-xl shadow-sm bg-white w-[190px] aspect-auto p-3 flex flex-col items-center justify-center">
                            <img src="http://127.0.0.1:5000/person_img/{{$item->personExit->img}}" alt="img" class=" w-full max-w-[140px] min-w-[90px] h-[250px]  object-fill object-center"> 
                            <button class="rounded-xl bg-blue-400 hover:bg-blue-700 p-1 px-2 mt-3 " >No</button>
                        </div>
                        @else
                        <p class="text-white">Sorry that person not exited yet or not detected</p>
                        @endif
                    </div>
                </div> 
            
            @endforeach
          
        </div>    
    </div>

    <script>
        function checker(e){
          
           const modal = e.currentTarget.closest('div').querySelector('.modalView')
           const Bgopacity = document.getElementById('bg')
           modal.classList.toggle('hidden')
           Bgopacity.classList.toggle('hidden')
           
        }
    </script>
   
</x-staff-app-layout>
