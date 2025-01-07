  
      <aside id='sidebar'  class=" h-full  w-56 fixed top-0 left-0 dark: dark:bg-[#212631] dark:text-white transform  transition-transform duration-500">
         
         <header id='sidebar-header' class="border-b sticky border-1 dark:border-gray-700 mx-auto h-[68px] flex flex-row justify-start">
            <img src="{{asset('img/UTHM_Logo.png')}}" class="w-9 ml-2 aspect-square my-auto" alt="Logo">
            <p class="dark:text-white  self-center content-center text-lg ml-1 tracking-wider">PTTA</p>
         </header>


         <div class="px-3 py-4 overflow-y-auto ">
            <ul class="space-y-2 font-serif">
                  <li class="h-fit">
                     <a href="{{route('staff.dashboard')}}" class="flex h-10 items-center p-2 font-thin rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::route()->named('staff.dashboard') ? 'bg-gray-700' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white  {{ Request::route()->named('staff.dashboard') ? 'dark:text-white ' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                           <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                           <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                        </svg>
                        <span class="ms-3">Dashboard</span>
                     </a>
                  </li>
                  <li class="h-fit">
                     <a href="{{route('staff.account')}}" class="flex h-10 items-center p-2 font-thin rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::route()->named('staff.account') ? 'bg-gray-700' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white {{ Request::route()->named('staff.account') ? 'dark:text-white' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                           <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                           <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                        </svg>
                        <span class="ms-3">Account</span>
                     </a>
                  </li>
                  <li class="h-fit">
                     <a href="{{route('staff.monitor')}}" class="flex h-10 items-center p-2 font-thin rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::route()->named('staff.monitor') ? 'bg-gray-700' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white {{ Request::route()->named('staff.monitor') ? 'dark:text-white ' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                           <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                           <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                        </svg>
                        <span class="ms-3">Monitor</span>
                     </a>
                  </li>
                  <li class="h-fit">
                     <a href="{{route('staff.report')}}" class="flex h-10 items-center p-2 font-thin rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::route()->named('staff.report') ? 'bg-gray-700' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white {{ Request::route()->named('staff.report') ? 'dark:text-white ' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                           <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                           <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                        </svg>
                        <span class="ms-3">Report</span>
                     </a>
                  </li>
                 
                  <li class="h-fit">
                     <a href="{{route('staff.occupancy')}}" class="flex h-10 items-center p-2 font-thin rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::route()->named('staff.occupancy') ? 'bg-gray-700' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white {{ Request::route()->named('staff.occupancy') ? 'dark:text-white ' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                           <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                           <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                        </svg>
                        <span class="ms-3">Occupancy</span>
                     </a>
                  </li>

                  <li class="h-fit">
                     <a href="{{route('staff.room')}}" class="flex h-10 items-center p-2 font-thin rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::route()->named('staff.room') ? 'bg-gray-700' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white {{ Request::route()->named('staff.room') ? 'dark:text-white ' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                           <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                           <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                        </svg>
                        <span class="ms-3">Room</span>
                     </a>
                  </li>

                  <li class="h-fit">
                     <a href="{{route('staff.room')}}" class="flex h-10 items-center p-2 font-thin rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::route()->named('staff.room') ? 'bg-gray-700' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white {{ Request::route()->named('staff.room') ? 'dark:text-white ' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                           <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                           <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                        </svg>
                        <span class="ms-3">Reservation</span>
                     </a>
                  </li>
                  <li class="h-fit">
                     <a href="{{route('staff.room')}}" class="flex h-10 items-center p-2 font-thin rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::route()->named('staff.room') ? 'bg-gray-700' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white {{ Request::route()->named('staff.room') ? 'dark:text-white ' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                           <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                           <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                        </svg>
                        <span class="ms-3">System Setting</span>
                     </a>
                  </li>
            </ul>
         </div> 
      </aside>
  

