<x-app-layout>

    <style>
        body {
          background-color: #0c0f16; 
        }
    </style>
        

    <div class="absolute top-0 left-0 w-full p-0 m-0 dark">
        <div class="fixed backdrop-blur-lg bg-opacity-30 w-full z-10 flex justify-center">
            <div class="flex flex-wrap flex-row items-center justify-between w-full h-[6%] pt-[5px] px-5 max-w-[1300px] gap-[3rem] max-[700px]:gap-2">

                <div class=" h-full flex flex-1 flex-wrap flex-row items-center min-[900px]:gap-[5rem]">

                    <!-- menu bar -->
                    <div class="max-[800px]:flex min-[800px]:hidden mr-2 justify-center items-center">
                        <i class="text-slate-200  mr-6 fa-solid fa-bars fa-xl cursor-pointer"></i>
                    </div>

                    <!-- title -->
                    <div class="flex flex-row items-center justify-center gap-2">
                        <img class="w-[40px] h-[40px]" src="{{asset('img/UTHM_Logo.png')}}" alt="">
                        <div class="flex flex-col">
                                <span class="self-center text-l font-[400] whitespace-nowrap dark:text-white">Perpustakaan Tunku </span>
                                <span class="self-center text-l font-[400] whitespace-nowrap dark:text-white">Tun Aminah</span>
                        </div>
                    </div>

                    <!-- search -->
                    <div class="flex-1 max-[550px]:hidden p-2 min-w-[200px] max-w-xl">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900  rounded-xl shadow-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:border-none dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required />
                        </div>
                    </div>
                    
                </div>

                <!-- link -->

                <div class="flex max-[800px]:gap-0 gap-5 ">

                    <nav class="max-[800px]:hidden h-full flex flex-nowrap items-center w-[25%] max-w-[400px] min-w-[250px] justify-center p-[10px]">
                        <ul class="flex flex-wrap grow flex-row justify-center">
                            <li class="text-white flex grow flex-shrink px-2 justify-center montserrat-medium" v-for="link in links" :key="link">
                                <a href="/" aria-current="page">Home</a>
                            </li>
                            <li class="text-white flex grow flex-shrink px-2 justify-center montserrat-medium" v-for="link in links" :key="link">
                                <a href="/" aria-current="page">Home</a>
                            </li>
                            <li class="text-white flex grow flex-shrink px-2 justify-center montserrat-medium" v-for="link in links" :key="link">
                                <a href="/" aria-current="page">Home</a>
                            </li>
                        </ul>
                    </nav>

                    <!-- search icon -->
                    <div class="hidden flex justify-center items-center mr-4">                          
                         <i  class="text-slate-200 fa-solid fa-magnifying-glass cursor-pointer"></i>                               
                    </div>

                    <!-- account section -->

                    <div class="flex items-center w-[15%] max-w-[80px] min-w-[50px] justify-end max-[355px]:hidden">
                        <img src="{{asset('img/UTHM_Logo.png')}}" class="rounded-full w-[40px] h-[40px] border-[1px] border-indigo-300" alt="">
                    </div>

                </div>
            </div>
        </div>

        <!-- sidebar -->

        <div class="hidden fixed z-20 p-0 inset-0 w-full h-screen  before:absolute before:inset-0 before:w-full before:h-screen before:bg-slate-900 before:opacity-[.92]">
            <aside class="absolute w-2/5 h-screen bg-indigo-900">
                <i class="fa-solid fa-xmark fa-xl text-white absolute top-[50px] left-6 right-10 cursor-pointer"></i>
                <ul class="pt-9">
                    <li  class="pt-[70px] cursor-pointer grid grid-flow-col text-white text-center"> 
                     
                    </li>
                </ul>
            </aside>
        </div>

        <!-- search modal -->

        <div class="hidden z-20 before:absolute before:inset-0  before:bg-slate-900 before:opacity-[.92] fixed inset-0 w-full h-screen px-[30px]">
            <div class="absolute inset-0 px-[50px] py-[30px]">  
                    <div class="relative inset-0">
                        <div class="absolute inset-0 flex items-center ps-4 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required />
                        <i class="fa-solid text-gray-500 dark:text-gray-400 fa-xmark fa-lg  absolute top-[50%] right-[10px]   cursor-pointer"></i>
                    </div>
            </div>
        </div>
</div>


<main class="h-[60svh] max-h-[600px] w-full flex justify-center items-center">
    <div class="container h-[80%] max-[500px]:mt-[60px] mt-[120px]  flex items-centers justify-center  mx-auto p-10 min-[1300px]:p-5  max-w-[1300px]">
        <div class="text-center flex-1 content flex flex-col justify-center box-border max-w-[550px]">
            <h1 class="max-[500px]:text-xl text-slate-300 montserrat-medium text-3xl tracking-widest mb-10"><span class="text-teal-200">3D Printing</span> Marketplace</h1>
            <p class="max-[500px]:text-xs  montserrat-regular text-slate-300 text-sm tracking-wider leading-relaxed ">A 3D printing marketplace connects creators, businesses, and hobbyists with a diverse range of products.</p>
            <div class="flex justify-center flex-row max-sm:gap-3 gap-10 mt-10"> 
             
                <button  class="max-lg:text-xs text-slate-200 uppercase montserrat-regular border-2 rounded-lg p-3 border-teal-200 hover:bg-teal-600 hover:border-teal-600 hover:text-white">Sell 3D Model</button>
              
            </div>
        </div>
      
    </div>
    
</main>
<!-- circle design -->


 


</x-app-layout>