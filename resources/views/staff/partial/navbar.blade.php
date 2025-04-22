<nav id='navbar' class="sticky top-0 left-0 h-[68px] shadow-md ml-56  flex  items-center bg-white  transition-all  z-10  duration-500">
    <div class="flex  justify-start content-start h-full p-3">
        <i onclick="sidebar_togle()" class="fa-solid fa-bars fa-lg w-[25px] hover:cursor-pointer  dark:text-gray-600 content-center"></i>
    </div>

    <div class="dark flex items-center mr-10 max-sm:mr-6 flex-1 justify-end content-end">
        <div class="flex items-center ms-3">
          <div>
            <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
              <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
            </button>
          </div>
          <div class="hidden" id="dropdown-user">
            <div class=" mr-5 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm dark:bg-gray-700 dark:divide-gray-600" >
               <div class="px-4  py-3" role="none">
                  <p class="text-sm text-gray-900 dark:text-white" role="none">
                  {{auth()->user()->name}}
                  </p>
                  <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                    {{auth()->user()->email}}
                  </p>
               </div>
               <ul class="py-1" role="none">
                
                  <li>
                  <a href="{{route('staff.profile.edit')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Profile</a>
                  </li>
                 
                  <li>
                     <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 w-full text-sm text-start text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</button>
                     </form>
                  </li>
               </ul>
            </div>
          </div>
        </div>
      </div>
</nav>

<div class="ml-56 transition-all flex flex-col min-h-full items-stretch justify-stretch duration-500" id='content' >
    {{ $slot }}
</div>


<script>
    const mediaQuery = window.matchMedia('(max-width: 740px)');

    const sidebar = document.getElementById('sidebar')
    const navbar = document.getElementById('navbar')
    const content = document.getElementById('content')


    function sidebar_togle(){
       
        if(sidebar.classList.contains('-translate-x-full')){
            sidebar.classList.remove('-translate-x-full');
            navbar.classList.add('ml-56');
            content.classList.add('ml-56');
        }else{
           
            sidebar.classList.add('-translate-x-full');
            navbar.classList.remove('ml-56');
            content.classList.remove('ml-56');
        }
    }


    function adjustLayoutBasedOnViewport() {
   
    
      if (mediaQuery.matches) {

          sidebar.classList.add('-translate-x-full');
          navbar.classList.remove('ml-56');
          content.classList.remove('ml-56');
      } else {
          
          
          sidebar.classList.remove('-translate-x-full');
          navbar.classList.add('ml-56');
          content.classList.add('ml-56');
      }
}

window.addEventListener('load', adjustLayoutBasedOnViewport);

// Run on resize
window.addEventListener('resize', adjustLayoutBasedOnViewport);



</script>