


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
              <div class="relative bg-white rounded-lg shadow-sm dark:bg-[#11151f]">
                  <div class="flex items-center justify-betwen p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                          Select Day Slot
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
                                <label for="" class='text-white text-md mb-4 '>Select Date: </label>  
                                <div class="flex flex-col justify-center items-center w-full">
                                    <div class="flex justify-between gap-2 items-center text-lg font-semibold text-gray-800 mb-4">
                                        <button id="prevMonthBtn" class="px-2 py-0! bg-gray-300 text-gray-500 rounded-sm cursor-not-allowed" disabled><i class="fa-solid fa-arrow-left fa-sm"></i></button>
                                        <span class="text-white" id="monthDisplay"></span>
                                        <button id="nextMonthBtn" class="px-2 py-0! bg-blue-500 text-white rounded-sm hover:bg-blue-700"><i class="fa-solid fa-arrow-right fa-sm"></i></button>
                                    </div>
                                    <div class="grid grid-cols-7 gap-1 mb-2 text-center text-white font-bold w-fit">
                                        <div class=" w-7">S</div><div class=" w-7">M</div><div class=" w-7">T</div><div class="w-7">W</div><div class="w-7">T</div><div class=" w-7">F</div><div class="w-7">S</div>
                                    </div>                             
                                    <div id="calendar" class="grid grid-cols-7 gap-1 w-fit"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="data_store()" data-modal-toggle="slot-modal" class="text-slate-700 inline-flex items-center mt-6  bg-teal-200 hover:bg-teal-700 focus:outline-hidden  font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-teal-200 dark:hover:bg-teal-700  mx-auto">
                        Save
                    </button>
                </div>      
              </div>
           </div>   
      </div> 
    
      <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
            let today = new Date();
            let currentYear = today.getFullYear();
            let currentMonth = today.getMonth(); 
            let selectedMonth = currentMonth;

            let selected_room_id = '';

        document.addEventListener('DOMContentLoaded', () => {
           
            updateCalender();
            check_available();
        
        });

        function updateCalender(){
            const calendar = document.getElementById("calendar");
            const monthDisplay = document.getElementById("monthDisplay");
            const prevMonthBtn = document.getElementById("prevMonthBtn");
            const nextMonthBtn = document.getElementById("nextMonthBtn");
            calendar.innerHTML = "";

            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            monthDisplay.textContent = `${monthNames[selectedMonth]}`;

            let firstDay = new Date(currentYear, selectedMonth, 1).getDay(); 
            let totalDays = new Date(currentYear, selectedMonth + 1, 0).getDate(); 

            for (let i = 0; i < firstDay; i++) {
                let emptyCell = document.createElement("div");
                calendar.appendChild(emptyCell);
            }

            for (let day = 1; day <= totalDays; day++) {
                let dayCell = document.createElement("button");
                dayCell.textContent = day;
                dayCell.id = day;
                dayCell.setAttribute('data-room-id', '');
                dayCell.className = "p-1 w-7 bg-blue-500 btn_day text-white text-center rounded-sm cursor-pointer hover:bg-blue-700";
                calendar.appendChild(dayCell);
            }

            prevMonthBtn.disabled = selectedMonth === currentMonth;
            prevMonthBtn.className = selectedMonth === currentMonth
                ? "px-2 py-0 bg-gray-300 text-gray-500 rounded-sm cursor-not-allowed"
                : "px-2 py-0 bg-blue-500 text-white rounded-sm hover:bg-blue-700";

            nextMonthBtn.disabled = selectedMonth === currentMonth + 1;
            nextMonthBtn.className = selectedMonth === currentMonth + 1
                ? "px-2 py-0 bg-gray-300 text-gray-500 rounded-sm cursor-not-allowed"
                : "px-2 py-0 bg-blue-500 text-white rounded-sm hover:bg-blue-700";
        }

        
        document.getElementById("prevMonthBtn").addEventListener("click", () => {
            if (selectedMonth > currentMonth) {
                selectedMonth--;     
                updateCalender();
                check_available();
            }
        });

        document.getElementById("nextMonthBtn").addEventListener("click", () => {
            if (selectedMonth < currentMonth + 1) {
                selectedMonth++;
                updateCalender();
                check_available();
            }
        });
        

        let formattedDate;

        async function check_available(){
            try{
               
                let room_id = {{$room->id}}
                console.log("ggg" + room_id)
                const response = await axios.get(`/student/api/reservation_slot/date/${room_id}/${selectedMonth + 1}`);
                console.log(response.data)

                const today = new Date();
                today.setHours(0, 0, 0, 0);

                response.data.forEach(item => {
                    if(!item.available){
                      
                        document.getElementById(item.date).classList.remove('bg-blue-500' , 'hover:bg-blue-700');
                        document.getElementById(item.date).classList.add('bg-red-500', 'cursor-not-allowed');
                        document.getElementById(item.date).disabled = true;
                    }else{
                    
                        document.getElementById(item.date).setAttribute('data-room-id', item.id);
                    }
                  
                });

                
                document.querySelectorAll("[id]").forEach(element => {
                    let date = parseInt(element.id); 
                    let currentYear = today.getFullYear();
                    let fullDate = new Date(currentYear, selectedMonth, date);

                    if (fullDate < today) {
                        element.classList.remove('bg-blue-500', 'hover:bg-blue-700' , 'bg-red-500','cursor-pointer' );
                        element.classList.add('bg-gray-500', 'text-gray-300', 'cursor-not-allowed');
                        element.disabled = true;
                    }
                });

                
                document.querySelectorAll('.btn_day').forEach((btn)=>{
                    btn.addEventListener('click', (e)=>{
                        let clickedBtn = e.target;

                        document.querySelectorAll('.btn_day').forEach((b)=>{

                            if(b.classList.contains('bg-teal-300')){
                                b.classList.add('bg-blue-500', 'hover:bg-blue-700');
                                b.classList.remove('bg-teal-300', 'hover:bg-teal-500');
                            }

                        });

                      
                        if(clickedBtn.classList.contains('bg-blue-500')){
                            clickedBtn.classList.remove('bg-blue-500', 'hover:bg-blue-700');
                            clickedBtn.classList.add('bg-teal-300', 'hover:bg-teal-500');

                            selected_room_id = clickedBtn.getAttribute('data-room-id');

                        }else{
                            clickedBtn.classList.add('bg-blue-500', 'hover:bg-blue-700');
                            clickedBtn.classList.remove('bg-teal-300', 'hover:bg-teal-500');
                        }

                        let selectedDay = clickedBtn.id;
                        let formattedMonth = String(selectedMonth + 1).padStart(2, "0"); 
                        let formattedDay = String(selectedDay).padStart(2, "0"); 

                        formattedDate = `${currentYear}-${formattedMonth}-${formattedDay}`; 
                       

                    });
                });

            }catch(error){
                console.log(error)
            }
        }

        function data_store(){

            const date = document.getElementById('date');
            const room_id = document.getElementById('roomID');


            const i_date = document.querySelector('[name="date"]');

            room_id.value = selected_room_id;
            date.textContent = formattedDate;
            i_date.value = formattedDate;


        }


      
    
    </script>
      
    
    