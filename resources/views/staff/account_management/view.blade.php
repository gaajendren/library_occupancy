<div id="view-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-[100%] ">
    <div class="absolute top-0 left-0 bg-gray-700 w-full min-h-[110%] h-full opacity-60" style="bottom: auto;"></div>
    <div class="relative p-4 w-full sm:max-w-md md:max-w-lg  max-w-md  max-h-full my-10">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="title text-xl font-semibold text-gray-900 dark:text-white">
                 View Account
                </h3>
                <button type="button" onclick="reset()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="view-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-4 space-y-5">
                    <div class="mb-5">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <p  id="v_name" name='name'  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></p>
                    </div>
                    <div class="mb-5">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <p  name='email' id="v_email"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></p>
                    </div>

                    <div class="mb-5 flex gap-4 items-center flex-row w-full">
                        <div class="flex flex-col w-1/3 items-start justify-center">
                            <label for="contact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact</label>
                            <div class="flex w-full flex-row items-center gap-2">
                                <p  name="contact" id="v_contact" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></p>                                     
                            </div>
                        </div>
                        <div class="flex flex-col w-1/3  items-start justify-center">
                            <label for="ic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IC No</label>
                            <div class="flex w-full flex-row items-center gap-2">
                                <p  name="ic" id="v_ic" class="bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></p>           
                            </div>
                        </div>
                        <div class="flex flex-col w-1/3 items-start justify-center">
                            <label for="roles" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                            <div class="flex w-full flex-row items-center gap-2">
                                <p id="v_roles" name='roles' class="bg-gray-50  border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></p>    
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                        <textarea name="address" id="v_address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled ></textarea>
                    </div>
            </div>
        </div>
    </div>
</div>


