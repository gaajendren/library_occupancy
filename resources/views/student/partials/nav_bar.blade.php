<header class="w-full h-[55px] fixed top-0 z-50 dark">
    <nav class="p-[1rem]  bg-transparent border-gray-200 dark:white flex  items-center justify-center w-full">
      <div class="relative max-w-(--breakpoint-xl) w-full flex flex-wrap items-center justify-between mx-auto ">
       <a href="" class="flex items-center space-x-3 rtl:space-x-reverse z-10">
          @use('App\Models\Setting');
          @php
              $setting_logo = Setting::first();
          @endphp
           <img src="{{  url($setting_logo->logo)}}" class="h-8" alt="PTTA Logo" />
           <div class="flex flex-col">
             <span class="self-center text-l font-[400] whitespace-nowrap dark:text-white">Perpustakaan Tunku </span>
             <span class="self-center text-l font-[400] whitespace-nowrap dark:text-white">Tun Aminah</span>
           </div>
       </a>
       <div class="md:absolute md:inset-0 z-0 items-center justify-between  w-full md:flex md:w-auto md:order-1" id="navbar-user">
        <ul class="flex flex-col m-auto font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent dark:bg-transparent dark:border-gray-700">
          <li>
            <a href="{{route('student.dashboard')}}" class="block py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-white" aria-current="page">Home</a>
          </li>
          
          <li>
            <a href="{{route('student.history')}}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 ">History</a>
          </li>
        </ul>
       </div>
       <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse z-10">
           <button type="button" class="flex text-sm bg-tansparaent rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
             <span class="sr-only">Open user menu</span>
             <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
           </button>
           <!-- Dropdown menu -->
           <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
             <div class="px-4 py-3">
               <span class="block text-sm text-gray-900 dark:text-white">{{auth()->user()->name}}</span>
               <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{auth()->user()->email}}</span>
             </div>
             <ul class="py-2" aria-labelledby="user-menu-button">
               <li>
                 <a href="{{route('student.dashboard')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                 <a href="{{route('student.profile.edit')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                
                  <form action="{{route('logout')}}" method="post">
                     @csrf
                     <button onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 w-full text-sm text-start text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</button>
                  </form>
              
               </li>
             </ul>
           </div>
           <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-hidden focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
             <span class="sr-only">Open main menu</span>
             <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                 <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
             </svg>
           </button>
       </div>
       
      </div>
     </nav>
 </header>
   