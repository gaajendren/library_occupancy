<x-app-layout >

    <style>
      
        nav {
            transition: background-color 0.3s ease, backdrop-filter 0.3s ease;
        }
        
        
        nav.scrolled {
            background-color: rgba(255, 255, 255, 0.1); 
            backdrop-filter: blur(30px);
           
        }
        </style>

<div class="w-full min-h-screen bg-[#0c0f16]">
   
   @include('student.partials.nav_bar')
   @include('student.partials.top_into')
   @include('student.partials.filter')
   @include('student.partials.banner')




   {{-- <main class="max-w-[1500px] mx-auto">
      <div class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-3 grid-cols-2 md:gap-10 sm:gap-6 gap-4 md:m-[5rem] sm:m-[2rem] m-[1rem]" id="innovations-container">
         <!-- Dynamic content will be inserted here -->
      </div>
   </main> --}}

</div>

<script>
   document.addEventListener("DOMContentLoaded", async () => {
       const innovationsContainer = document.getElementById("innovations-container");

       try {
           const response = await axios.get('http://127.0.0.1:8000/room');
           const innovations = response.data;

           innovations.forEach(innovation => {
               const card = document.createElement("div");
               card.className = "bg-slate-900 cursor-pointer hover:bg-slate-700 relative rounded-lg shadow-lg";

               card.innerHTML = `
                   <div class="p-0">
                       <img src="${innovation.img}" class="h-[150px] rounded-t-lg mb-3 object-cover w-full" alt="Prototype Image Showcase">
                       <h4 class="m-3 mb-0 max-sm:text-xs max-md:text-sm text-lg text-slate-300 leading-relaxed">${innovation.title}</h4>
                       <p class="ml-3 mb-0.5 text-red-500 font-semibold text-lg">
                           <span class="font-normal text-xs">RM </span>${innovation.price}
                       </p>
                   </div>
                   <div class="flex flex-row items-center justify-between p-3 pt-0">
                       <i class="fa-solid fa-fire-flame-curved fa-sm text-teal-500">
                           <p class="text-gray-200 text-sm ml-2 inline-block">${innovation.score}</p>
                       </i>
                       <p class="text-gray-200 text-sm">${innovation.sold}<span class="text-xs"> sold</span></p>
                   </div>
               `;

               innovationsContainer.appendChild(card);
           });
       } catch (e) {
           console.error("Error fetching data:", e);
       }
   });
</script>



<div class="rounded-full blur-[120px] opacity-60 bg-teal-300 w-[10%] h-[140px] absolute top-[25%] left-[20%]"></div>

<div class="absolute top-[35%] left-[80%]  rounded-full blur-[120px] opacity-60 bg-teal-300 w-[10%] h-[140px]"></div>

{{-- <div class="absolute top-0 left-0 w-full h-screen bg-gradient-to-b from-teal-100 to-transparent opacity-5">
   <div class="w-full h-screen bg-teal-100 opacity-5 absolute top-0 left-0" style="background: linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 1) 100%); backdrop-filter: blur(5px);">
   </div>
</div> --}}

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const header = document.querySelector("nav");
    
        window.addEventListener("scroll", () => {
            if (window.scrollY > 55) { 
                header.classList.add("scrolled");
            } else {
                header.classList.remove("scrolled");
            }
        });
    });
    </script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</x-app-layout>
