<x-app-layout >



<div class="w-full min-h-screen bg-[#0c0f16]">
   
   @include('student.partials.nav_bar')
   @include('staff.message.success')
   @include('student.partials.top_into')
   @include('student.partials.banner')
   @include('student.partials.filter')


   <main class="max-w-screen-xl mx-auto  dark md:p-[2rem] sm:p-[1rem] p-[1rem] pt-[10px]">    
        <div class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-3 grid-cols-2 md:gap-10 sm:gap-6 gap-4 " id='room_catalog'>
           
        </div>
   </main>

  

</div>

<script>

    let room_list = [];


   document.addEventListener("DOMContentLoaded", async () => {
       const roomContainer = document.getElementById("room_catalog");

       try {
           const response = await axios.get('http://library_occupancy.test/student/api/rooms');
           room_list = response.data;

           room_catalog(room_list, roomContainer)

  
       } catch (e) {
           console.error("Error fetching data:", e);
       }
   });


   function room_catalog(room_list ,roomContainer){

        room_list.forEach(room => {
            const img = JSON.parse(room.img)
            
               const card = document.createElement("div");
               card.className = "";

               card.innerHTML = `
                   <div class="py-1 pb-2 ">
                       <a href="http://library_occupancy.test/student/room_detail/${room.id}"><img src="http://library_occupancy.test/storage/room_image/${img[0]}" onmouseover="textRoomShow(this)" onmouseout="textRoomHide(this)" class="h-[150px] rounded-xl object-cover w-full cursor-pointer " alt="Prototype Image Showcase"></a>
                        <div  class="opacity-0 translate-y-0 transition-transform duration-300 ease-out text-teal-200 max-sm:text-xs max-md:text-sm text-md viewDetail " >View Details</div>
                       <h4 class="opacity-100 transition-opacity duration-400 ease-out w-fit max-sm:text-xs max-md:text-sm text-md text-slate-300 leading-relaxed font-semibold room_desc">${room.title}</h4>
                       <p class="opacity-100 transition-opacity duration-400 ease-out w-fit  text-xs text-slate-300 font-reqular room_desc">Seat : ${room.min_seat} - ${room.max_seat}</p>
                
                   </div>    
               `;

               roomContainer.appendChild(card);
           });
   }

   function textRoomShow(x) {
        const parentContainer = x.closest('div');
        const roomTitle = parentContainer.querySelectorAll('.room_desc');
        const overlay_text = parentContainer.querySelector('.viewDetail');

        overlay_text.classList.add('translate-y-6')
        overlay_text.classList.remove('opacity-0');

        roomTitle.forEach(b=>{
            b.classList.add('opacity-0');
            b.classList.remove('opacity-100'); 
        });

        
       
    }

    function textRoomHide(x) {
        const parentContainer = x.closest('div');
        const roomTitle = parentContainer.querySelectorAll('.room_desc');
        const overlay_text = parentContainer.querySelector('.viewDetail');

        
      
        overlay_text.classList.remove('translate-y-6');
        overlay_text.classList.add('translate-y-0');


        setTimeout(() => {
            overlay_text.classList.add('opacity-0');
        }, 200);

        setTimeout(()=>{
            roomTitle.forEach(b=>{
                b.classList.remove('opacity-0'); 
                b.classList.add('opacity-100'); 
            });
        }, 300)
    }
</script>



<div class="rounded-full blur-[120px] opacity-60 bg-teal-300 w-[10%] h-[140px] absolute top-[25%] left-[20%]"></div>

<div class="absolute top-[35%] left-[80%]  rounded-full blur-[120px] opacity-60 bg-teal-300 w-[10%] h-[140px]"></div>

{{-- <div class="absolute top-0 left-0 w-full h-screen bg-gradient-to-b from-teal-100 to-transparent opacity-5">
   <div class="w-full h-screen bg-teal-100 opacity-5 absolute top-0 left-0" style="background: linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 1) 100%); backdrop-filter: blur(5px);">
   </div>
</div> --}}







<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</x-app-layout>
