

    <div id="default-modal" tabindex="-1" aria-hidden="true" class="dark hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Coordinate the ROI
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
        
                    <div class="w-full flex flex-col gap-2 justify-center items-center">
                    
                        <br>

                        <div class="relative w-[320px] aspect-[2]">
                            <img  class="w-full h-full frame_model" id="enter_frame_model" src="" alt="">
                           
                            <svg class="absolute inset-0 w-full h-full pointer-events-none">
                                  
                                <polygon id="CardPloy" fill="none" stroke="red" stroke-width="2" />
                            </svg>

                            <svg class="absolute inset-0 w-full h-full pointer-events-none">
                                
                                <polygon id="polygon" fill="none" stroke="purple" stroke-width="2" />
                            </svg>
                            <p id="coordinates" class="absolute top-0 left-0 bg-black bg-opacity-50 px-2 py-1 text-sm rounded-md">
                                X: 0, Y: 0
                            </p>
                        </div>

                        <div class="flex flex-col w-full p-5 pt-2 gap-3 justify-center items-center">
                            <div class="flex flex-row gap-4 items-evenly justify-evenly w-[320px]">
                                <div class="flex flex-row gap-2 items-center justify-center w-1/2">
                                    <button onclick="select_pointer(this, 'a')" class="btn text-sm text-white rounded-md shadow-sm px-3 py-1 bg-blue-500 hover:bg-blue-300" >A</button>

                                    <div class="flex flex-row justify-center items-center">
                                       <p id="a" class="text-white text-md">( 0 , 0 )</p>
                                    </div>
                                    
                                </div>
                                <div class="flex flex-row gap-2 items-center justify-center w-1/2">
                                    <button onclick="select_pointer(this, 'b')" class="btn text-sm text-white rounded-md shadow-sm px-3 py-1 bg-blue-500 hover:bg-blue-300" >B</button>
                                    <div class="flex flex-row justify-center items-center">
                                        <p id="b" class="text-white text-md">( 0 , 0 )</p>
                                     </div>
                                </div>
                            </div>
                            <div class="flex flex-row gap-4 items-evenly justify-evenly w-[320px]">
                                <div class="flex flex-row gap-2 items-center justify-center w-1/2">
                                    <button onclick="select_pointer(this, 'c')" class="btn text-sm text-white rounded-md shadow-sm px-3 py-1 bg-blue-500 hover:bg-blue-300" for="">C</button>
                                    <div class="flex flex-row justify-center items-center">
                                        <p id="c" class="text-white text-md">( 0 , 0 )</p>
                                     </div>
                                </div>
                                <div class="flex flex-row gap-2 items-center justify-center w-1/2">
                                    <button onclick="select_pointer(this, 'd')" class="btn text-sm text-white rounded-md shadow-sm px-3 py-1 bg-blue-500 hover:bg-blue-300" for="">D</button>
                                    <div class="flex flex-row justify-center items-center">
                                        <p id="d" class="text-white text-md">( 0 , 0 )</p>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                
 
                <!-- Modal footer -->
                <div class="flex justify-center items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id="upd_btn" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                    <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                </div>
            </div>
        </div>
    </div>

