<x-app-layout >

    <style>
@keyframes wave-horizontal {
    0% { transform: translateX(0) translateY(0); }
    50% { transform: translateX(-25%) translateY(-12px); }
    100% { transform: translateX(-50%) translateY(0); }
}

@keyframes wave-vertical {
    0%, 100% { transform: translateY(0); opacity: 0.15; }
    50% { transform: translateY(-15px); opacity: 0.22; } 
}

/* Base Wave Style */
.wave {
    position: absolute;
    width: 250%;
    height: 18rem;
    background-repeat: repeat-x;
    transform: translate3d(0, 0, 0);
    opacity: 0.18;
    border-radius: 50%; /* Makes the waves rounded */
}

/* First Layer - Smooth & Light */
.wave-1 {
    background: radial-gradient(circle, rgba(50, 180, 170, 0.22) 10%, rgba(10, 90, 85, 0.1) 80%);
    bottom: 8%;
    filter: blur(30px);
    animation: wave-horizontal 9s linear infinite, wave-vertical 11s ease-in-out infinite;
}

/* Second Layer - Stronger Contrast */
.wave-2 {
    background: radial-gradient(circle, rgba(30, 140, 130, 0.25) 15%, rgba(5, 70, 65, 0.08) 85%);
    bottom: 18%;
    filter: blur(40px);
    animation: wave-horizontal 13s linear infinite, wave-vertical 16s ease-in-out infinite;
}

/* Third Layer - More Rounded & Faint */
.wave-3 {
    background: radial-gradient(circle, rgba(20, 120, 110, 0.28) 20%, rgba(0, 50, 45, 0.05) 90%);
    bottom: 28%;
    filter: blur(60px);
    animation: wave-horizontal 17s linear infinite, wave-vertical 20s ease-in-out infinite;
}

        .wave-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 0;
        }

         /* New Particle Effects */
         @keyframes wave-motion {
        0%, 100% { transform: translateY(0) translateX(0); }
        50% { transform: translateY(-15px) translateX(10px); }
    }

    @keyframes wave-motion-delayed {
        0%, 100% { transform: translateY(0) translateX(0); }
        50% { transform: translateY(-20px) translateX(-10px); }
    }

    @keyframes pulse {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.1; transform: scale(0.95); }
    }

    .animate-wave {
        animation: wave-motion 6s ease-in-out infinite;
    }

    .animate-wave-delayed {
        animation: wave-motion-delayed 8s ease-in-out infinite;
    }

    .animate-pulse {
        animation: pulse 4s ease-in-out infinite;
    }

    /* Particle Animation */
    .particle {
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: rgba(0, 255, 255, 0.3);
        border-radius: 50%;
        opacity: 0.5;
        animation: wave-motion 10s ease-in-out infinite;
    }
    
</style>
    </style>

<div class="w-full min-h-screen bg-[#0c0f16] relative overflow-hidden">

    <div class="wave-wrapper">
        <div class="wave wave-1"></div>
        <div class="wave wave-2"></div>
        <div class="wave wave-3"></div>
    </div>

    <div class="absolute inset-0 pointer-events-none">
        <div class="particle absolute w-1 h-1 bg-teal-400/30 rounded-full animate-pulse"></div>
        <div class="particle absolute w-1 h-1 bg-teal-400/30 rounded-full animate-pulse"></div>
        <div class="particle absolute w-1 h-1 bg-teal-400/30 rounded-full animate-pulse"></div>
    </div>

    <div class="relative z-10">
   
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

  

</div>


<script>

    let room_list = [];
    const setting = [];
   
   document.addEventListener("DOMContentLoaded", async () => {
       const roomContainer = document.getElementById("room_catalog");

       try {
           const response = await axios.get('http://library_occupancy.test/student/api/rooms');
           room_list = response.data;

           room_catalog(room_list, roomContainer)

  
       } catch (e) {
           console.error("Error fetching data:", e);
       }

       const particleContainer = document.body; // Use body for full-page effect
        for (let i = 0; i < 6; i++) { // Reduced number of particles
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.cssText = `
                left: ${Math.random() * 100}vw;
                top: ${Math.random() * 100}vh;
                animation-delay: ${Math.random() * 5}s;
                animation-duration: ${6 + Math.random() * 4}s;
            `;
            if (i % 2 === 0) {
                particle.classList.add('animate-wave');
            } else {
                particle.classList.add('animate-wave-delayed');
            }
            particleContainer.appendChild(particle);
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




<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</x-app-layout>
