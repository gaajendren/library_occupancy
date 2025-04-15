<main class="max-w-screen-xl mx-auto dark:bg-gray-800 p-4 md:p-8 mt-[3.5rem]">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
   
   <div class="banner w-full flex flex-col md:flex-row gap-4 h-[300px] md:h-[300px]">
       <!-- Main Carousel -->
       <div class="w-full md:w-[60%] flex flex-col h-full">
           <div class="swiper-container relative rounded-xl overflow-hidden shadow-xl h-full">
               <div class="swiper-wrapper h-full">
                @php
                    $banners = json_decode($setting->banner, true);
                @endphp

                @if(isset($banners['slider_image']))
                    @foreach ($banners['slider_image'] as $slider)

                    <div class="swiper-slide">
                        <img src="{{ asset('img/' . $slider) }}"
                                class="w-full h-full object-cover object-center"
                                alt="Slide 1">
                    </div>
                    
                    @endforeach
                @endif
                
            
               </div>

               <!-- Dark Navigation Buttons -->
               <div class="swiper-button-next !w-10 !h-10 bg-gray-800/30 hover:bg-gray-800/50 rounded-full backdrop-blur-sm">
                   <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                   </svg>
               </div>
               <div class="swiper-button-prev !w-10 !h-10 bg-gray-800/30 hover:bg-gray-800/50 rounded-full backdrop-blur-sm">
                   <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                   </svg>
               </div>

               <!-- Dark Pagination -->
               <div class="swiper-pagination !bottom-4"></div>
           </div>
       </div>

       <div class="w-full md:w-[40%] flex flex-col gap-4 h-full">
         <div class="relative group h-[calc(50%)] overflow-hidden rounded-xl shadow-lg hover:shadow-xl transition-all">
             <img src="{{ asset('img/' . $banners['banner_2']) }}" 
                  class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                  alt="Banner 1">
         </div>
         <div class="relative group h-[calc(50%)] overflow-hidden rounded-xl shadow-lg hover:shadow-xl transition-all">
             <img src="{{ asset('img/' . $banners['banner_3']) }}" 
                  class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                  alt="Banner 2">
         </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
   <script>
       const swiper = new Swiper('.swiper-container', {
           loop: true,
           speed: 800,
           autoplay: {
               delay: 3000,
           },
           pagination: {
               el: '.swiper-pagination',
               clickable: true,
               renderBullet: function (index, className) {
                   return `<span class="${className} w-3 h-3 bg-white/50 hover:bg-white/80 rounded-full transition-colors"></span>`;
               },
           },
           navigation: {
               nextEl: '.swiper-button-next',
               prevEl: '.swiper-button-prev',
           },
       });

      
   </script>

   <style>
       .swiper-button-next::after,
       .swiper-button-prev::after {
           content: '';
           display: none;
       }
       
       .swiper-button-next svg,
       .swiper-button-prev svg {
           width: 1.5rem;
           height: 1.5rem;
           color: rgba(31, 41, 55, 0.8); /* Gray-800 with opacity */
       }
       
       .swiper-pagination-bullet {
           background: rgba(31, 41, 55, 0.5) !important; /* Gray-800 with 50% opacity */
       }
       
       .swiper-pagination-bullet-active {
           background: rgba(31, 41, 55, 0.8) !important; /* Gray-800 with 80% opacity */
       }
       
       .swiper-pagination-bullet:hover {
           background: rgba(31, 41, 55, 0.7) !important;
       }
   </style>
</main>