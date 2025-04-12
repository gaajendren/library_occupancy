


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
    <div class="relative p-4 w-full max-w-3xl max-h-full">
          
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

                        <div class="flex flex-col " >
                            <label for="" class="text-white text-sm mb-4 w-full text-start">Select available time slot</label>
                            <div class='overflow-y-auto w-full flex justify-center flex-col items-start' style="scrollbar-color: #565c5b #0e0f0f">
                                <div class="max-w-[200px] flex flex-row gap-4 mt-4 hidden" id='timeSlotContainer'>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-available-id="" data-slot-id='8'>8.00 a.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-available-id='' data-slot-id='9'>9.00 a.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-available-id='' data-slot-id='10'>10.00 a.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-available-id='' data-slot-id='11'>11.00 a.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-available-id='' data-slot-id='12'>12.00 p.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-available-id='' data-slot-id='13'>1.00 p.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-available-id='' data-slot-id='14'>2.00 p.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-available-id='' data-slot-id='15'>3.00 p.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-available-id='' data-slot-id='16'>4.00 p.m</a>
                                    <a class="cursor-pointer px-3 py-2 bg-sky-400 rounded-md hover:bg-sky-700 text-gray-800 text-bold text-md text-center min-w-[100px]" data-available-id='' data-slot-id='17'>5.00 p.m</a>
                                </div>
                                <div class="max-w-[200px] flex flex-row gap-4  mb-4 hidden" id="timeRoomContainer">
                                    <a class="px-3 py-2 text-teal-300 text-bold text-sm text-center min-w-[100px] invisible" data-room-id='8'></a>
                                    <a class="px-3 py-2 text-teal-300 text-bold text-sm text-center min-w-[100px] invisible" data-room-id='9'></a>
                                    <a class="px-3 py-2 text-teal-300 text-bold text-sm text-center min-w-[100px] invisible" data-room-id='10'></a>
                                    <a class="px-3 py-2 text-teal-300 text-bold text-sm text-center min-w-[100px] invisible" data-room-id='11'></a>
                                    <a class="px-3 py-2 text-teal-300 text-bold text-sm text-center min-w-[100px] invisible" data-room-id='12'></a>
                                    <a class="px-3 py-2 text-teal-300 text-bold text-sm text-center min-w-[100px] invisible" data-room-id='13'></a>
                                    <a class="px-3 py-2 text-teal-300 text-bold text-sm text-center min-w-[100px] invisible" data-room-id='14'></a>
                                    <a class="px-3 py-2 text-teal-300 text-bold text-sm text-center min-w-[100px] invisible" data-room-id='15'></a>
                                    <a class="px-3 py-2 text-teal-300 text-bold text-sm text-center min-w-[100px] invisible" data-room-id='16'></a>
                                    <a class="px-3 py-2 text-teal-300 text-bold text-sm text-center min-w-[100px] invisible" data-room-id='17'></a>
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
    const timeRoomContainer = document.getElementById('timeRoomContainer');

    const timeSlots = timeSlotContainer.querySelectorAll('a');
    const timeRoom = timeRoomContainer.querySelectorAll('a');

    let selectedTime = []

    let reservationTime = []

    let max_slot ;



       
    async function getAvailableTime(event) {

        timeRoom.forEach((e)=>{
            e.classList.add('invisible')
            e.textContent = ''
        })

        timeSlots.forEach((e)=>{
            e.classList.remove('bg-teal-300', 'bg-sky-900' , '!bg-red-500');
            e.style.pointerEvents ='auto';
            e.classList.add('bg-sky-400');
            e.setAttribute('data-available-id', '');
        })


        if(event.value){
            timeSlotContainer.classList.remove('hidden')
            timeRoomContainer.classList.remove('hidden')
        }else{
            timeSlotContainer.classList.add('hidden')
            timeRoomContainer.classList.add('hidden')
        }

        try {
          
            const response = await axios.get(`/student/api/reservation_slot/{{$room->id}}/${event.value}`);

            max_slot = response.data[1];

            const today = new Date().toISOString().split('T')[0]; 

            let date = new Date()
 
            test1 = parseInt(date.getHours())

            console.log(test1);

            console.log(response.data);

     

      

        response.data[0].forEach((res)=>{
            const slotElement = document.querySelector(`[data-slot-id="${res.hour}"]`);
            const RoomElement = document.querySelector(`[data-room-id="${res.hour}"]`);

            if(slotElement && event.value == today && test1 >= parseInt(slotElement.getAttribute('data-slot-id'))){      
                slotElement.classList.remove('bg-teal-300', 'bg-sky-400' , '!bg-red-500')
                slotElement.classList.add('bg-sky-900')
                slotElement.style.pointerEvents = 'none';
                return;
            }

            if(!res.available){
                console.log('yes')      
                slotElement.classList.add('!bg-red-500')
                slotElement.classList.remove('bg-teal-300', 'bg-sky-400' , 'bg-teal-800')
                slotElement.style.pointerEvents ='none'
               
            } else{
               
                RoomElement.textContent = 'Room ' + res.room_id; 
                slotElement.setAttribute('data-available-id', `${res.room_id}`)
                RoomElement.classList.remove('invisible');
            }
            
        
           
        });
          
        } catch (error) {
            console.error(error);
        }
    }


   
    
    timeSlotContainer.querySelectorAll('a').forEach((b)=>{
        b.addEventListener('click', ()=>{

            const slotId = parseInt(b.getAttribute('data-slot-id'));

          

            if(selectedTime.length >= max_slot && !selectedTime.includes(slotId)){
                 alert('Reached Maksimim allowed slot for this room. Thank You');
                return;
             }

         
           if(selectedTime.includes(slotId)){
              selectedTime = selectedTime.filter((id) => id !== slotId);
           }
           else{
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
        const room_id = document.getElementById('roomID');

        const i_date = document.querySelector('[name="date"]');
        const i_time = document.querySelector('[name="time"]');

        const model_date = document.getElementById('model_date');
        
        date.textContent = model_date.value;
        i_date.value = model_date.value;

    
       let roomIdJson = [];

        selectedTime.forEach((time)=>{
            const roomEle = document.querySelector(`[data-slot-id="${time}"]`);

            
            if (roomEle) {
                const roomId = roomEle.getAttribute('data-available-id'); 
                reservationTime.push({ [roomId]: time }); 
            }
        });

        let firstRoomId = null;
        let hasDifferentRooms = false;

        reservationTime.forEach((reservation) => {
            const roomId = Object.keys(reservation)[0]; 

            if (firstRoomId === null) {
                firstRoomId = roomId; 
            } else if (firstRoomId !== roomId) {
                hasDifferentRooms = true; 
            }
        });

        if (hasDifferentRooms) {
           const status = confirm("You have selected different rooms. U need to change room after certain time period. Choose Wisely!!!");

           if(status){
                room_id.value = JSON.stringify(reservationTime);

                const formattedTimes = formatTimeSlots(selectedTime);
                time.textContent = formattedTimes.join(', ');
                i_time.value = JSON.stringify(formattedTimes);

           }else{
                date.textContent = " ";
                time.textContent = " ";
                i_date.value =" ";
                i_time.value = ' ';
           }
        } else{
                
                room_id.value = JSON.stringify(reservationTime);

                console.log(room_id.value);

                const formattedTimes = formatTimeSlots(selectedTime);
                time.textContent = formattedTimes.join(', ');
                i_time.value = JSON.stringify(formattedTimes);

        }

      
    }

function close_model(){
    document.getElementById('model_date').value = "";
    timeSlotContainer.classList.add('hidden');
    timeRoomContainer.classList.add('hidden');

    timeRoom.forEach((e)=>{
            e.classList.add('invisible')
            e.textContent = ''
        })

        timeSlots.forEach((e)=>{
            e.classList.remove('bg-teal-300', 'bg-sky-900' , '!bg-red-500');
            e.style.pointerEvents ='auto';
            e.classList.add('bg-sky-400');
            e.setAttribute('data-available-id', '');
        })

}
</script>
  

