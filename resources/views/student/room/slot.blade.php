


{{-- 
<label for="" class='text-white text-sm '>Available Time: </label>
<select name="time" class="w-[70%] rounded-xl text-gray-200 dark:bg-gray-700  shadow-lg border-none p-3 px-4 mb-3"  id="">
    <option value="" selected disabled>Select Time</option>
    <option value="16:00:00">4.00 pm</option>
    <option value=""></option>
    <option value=""></option>
</select>
    @error('time')
    <div class="text-red-400">{{ $message }}</div>
    @enderror --}}


  <div id="slot-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full dark">
    <div class="absolute top-0 left-0 w-full h-screen bg-gray-500 opacity-60"></div>
    <div class="relative p-4 w-full max-w-xl max-h-full">
          
          <div class="relative bg-white rounded-lg shadow dark:bg-[#11151f]">
              
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                      Select Time Slot
                  </h3>
                  <button type="button" onclick="close_model()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="slot-modal">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Close modal</span>
                  </button>
              </div>
             
            <div class="p-4 md:p-5 flex justify-center items-center flex-col">
                <div class="flex flex-col w-full">
                    <div class="flex flex-col gap-4 w-full">
                        <div class="flex flex-col">
                            <label for="" class='text-white text-sm '>Select Date: </label>
                            <input class="mt-3 w-[70%] rounded-xl text-gray-200 dark:bg-gray-700  shadow-lg border-none p-3 px-4 mb-3 text-sm" oninput='getAvailableTime(this)' id="model_date" type="date" min="{{date('Y-m-d')}}">
                               
                        </div>

                        <div class="flex flex-col max-h-[400px]" >
                            <label for="" class="text-white text-sm mb-4 w-full text-start">Select available time slot</label>
                            <div class='overflow-y-auto w-full flex justify-start flex-row items-center' style="scrollbar-color: #565c5b #0e0f0f">
                                <div class="max-w-[200px] flex flex-row gap-4 mt-4 mb-4 hidden" id='timeSlotContainer'>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-slot-id='8'>8.00 a.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-slot-id='9'>9.00 a.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-slot-id='10'>10.00 a.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-slot-id='11'>11.00 a.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-slot-id='12'>12.00 p.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-slot-id='13'>1.00 p.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-slot-id='14'>2.00 p.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-slot-id='15'>3.00 p.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-slot-id='16'>4.00 p.m</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="data_store()" data-modal-toggle="slot-modal" class="text-slate-700 inline-flex items-center mt-4  bg-teal-200 hover:bg-teal-700 focus:outline-none  font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-teal-200 dark:hover:bg-teal-700  mx-auto">
                    Save
                </button>
            </div>      
          </div>
       </div>   
  </div> 

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  

    const timeSlotContainer = document.getElementById('timeSlotContainer');
    const timeSlots = timeSlotContainer.querySelectorAll('a');
    let selectedTime = []
  

    async function getAvailableTime(event) {

        if(event.value){
            timeSlotContainer.classList.remove('hidden')
        }else{
            timeSlotContainer.classList.add('hidden')
        }

        try {
          
            const response = await axios.get(`/student/api/reservation_slot/{{$room->id}}/${event.value}`);

            timeSlots.forEach((e)=>{
                console.log(e.getAttribute('data-slot-id'));
                console.log(response.data);
                if(response.data.includes(parseInt(e.getAttribute('data-slot-id')))){
                    console.log('yes')
                    e.classList.add('!bg-red-500')
                    e.classList.remove('bg-teal-300', 'bg-sky-400')
                    e.style.pointerEvents = 'none';
                }else{
                    e.style.pointerEvents = 'auto';
                    e.classList.remove('!bg-red-500')
                    e.classList.add('bg-sky-400')
                }
            });

            
           
        } catch (error) {
            console.error(error);
        }
    }


   
    
    timeSlotContainer.querySelectorAll('a').forEach((b)=>{
        b.addEventListener('click', ()=>{

         
           const slotId = parseInt(b.getAttribute('data-slot-id'));
           if(selectedTime.includes(slotId)){
              selectedTime = selectedTime.filter((id) => id !== slotId);
           }else{
             selectedTime.push(slotId);
           }
           slotChecker(b)
        });
    });

    function slotChecker(b){
        let passTimeSlot = []
        if(selectedTime.length > 1){
            selectedTime.sort((a, b) => a - b); 

            for(i=0; i < selectedTime.length- 1; i++){
                if(selectedTime[i+1] - selectedTime[i] == 1 ){
                    if (!passTimeSlot.includes(selectedTime[i])) {
                        passTimeSlot.push(selectedTime[i]);
                    }
                    if (!passTimeSlot.includes(selectedTime[i + 1])) {
                        passTimeSlot.push(selectedTime[i + 1]);
                    }
                }else{
                    if (!passTimeSlot.includes(selectedTime[i])) {
                        passTimeSlot.push(selectedTime[i]);
                    }
                   break;
                }
            }
            selectedTime = passTimeSlot
        }

        timeSlots.forEach((slot) => {
        if (selectedTime.includes(parseInt(slot.getAttribute('data-slot-id')))) {
            slot.classList.add('bg-teal-300');
            slot.classList.remove('bg-sky-400');
        } else {
            slot.classList.add('bg-sky-400');
            slot.classList.remove('bg-teal-300');
        }
        });
           
        console.log(selectedTime)
    }

    function formatTimeSlots(times) {
    return times.map((time) => {
        const date = new Date();
        date.setHours(time, 0, 0); 
        const hours = date.getHours().toString().padStart(2, '0'); 
        const minutes = date.getMinutes().toString().padStart(2, '0'); 
        return `${hours}:${minutes}`;
    });
}

    function data_store(){
        const date = document.getElementById('date');
        const time = document.getElementById('time');

        const i_date = document.querySelector('[name="date"]');
        const i_time = document.querySelector('[name="time"]');

        const model_date = document.getElementById('model_date');
        
        date.textContent = model_date.value;
        i_date.value = model_date.value;

        const formattedTimes = formatTimeSlots(selectedTime);
        time.textContent = formattedTimes.join(', ');
        i_time.value = JSON.stringify(formattedTimes);
    }

function close_model(){
    document.getElementById('model_date').value = "";
    timeSlotContainer.classList.add('hidden');
}
</script>
  

