<div id="slot-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full dark">
    <div class="absolute top-0 left-0 w-full h-screen bg-gray-500 opacity-60"></div>
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-[#11151f]">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Select Year & Month
                </h3>
                <button type="button" id="close_model"  data-modal-toggle="slot-modal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                            <label for="" class='text-white text-md mb-4'>Select Year: </label>  
                            <div class="flex justify-center items-center text-lg font-semibold text-gray-800 mb-4">
                                <button id="prevYearBtn" class="px-2 py-0 bg-gray-300 text-gray-500 rounded-sm cursor-not-allowed" disabled>
                                    <i class="fa-solid fa-arrow-left fa-sm"></i>
                                </button>
                                <span class="text-white mx-4" id="yearDisplay"></span>
                                <button id="nextYearBtn" class="px-2 py-0 bg-blue-500 text-white rounded-sm hover:bg-blue-700">
                                    <i class="fa-solid fa-arrow-right fa-sm"></i>
                                </button>
                            </div>
                            <div id="monthSelector" class="grid grid-cols-4 gap-3 text-center w-fit mx-auto">
                                <!-- Months will be added dynamically -->
                            </div>                            
                        </div>
                    </div>
                </div>
                <button type="button" onclick="data_store()" class="text-slate-700 inline-flex items-center mt-6 bg-teal-200 hover:bg-teal-700 focus:outline-hidden font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-teal-200 dark:hover:bg-teal-700">
                    Save
                </button>
            </div>
        </div>
    </div>   
</div>

<script>
    let today = new Date();
    let currentYear = today.getFullYear();
    let selectedYear = currentYear;

    let selected_room_id = '';

    document.addEventListener('DOMContentLoaded', () => {
        updateYearSelector();
        check_available();
    });

    function updateYearSelector() {
        const yearDisplay = document.getElementById("yearDisplay");
        const prevYearBtn = document.getElementById("prevYearBtn");
        const nextYearBtn = document.getElementById("nextYearBtn");
        const monthSelector = document.getElementById("monthSelector");

        yearDisplay.textContent = selectedYear;
        monthSelector.innerHTML = "";

    
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        monthNames.forEach((month, index) => {
            let monthBtn = document.createElement("button");
            monthBtn.textContent = month;
            monthBtn.className = "p-2 w-full max-w-12 bg-blue-500 text-white rounded-sm cursor-pointer hover:bg-blue-700";
            monthBtn.setAttribute("data-room-id", '');
            monthBtn.setAttribute("data-month", index + 1);
            monthBtn.onclick = () => selectMonth(index + 1);
            monthSelector.appendChild(monthBtn);
        });

       
        prevYearBtn.disabled = selectedYear === currentYear;
        prevYearBtn.className = selectedYear === currentYear
            ? "px-2 py-0 bg-gray-300 text-gray-500 rounded-sm cursor-not-allowed"
            : "px-2 py-0 bg-blue-500 text-white rounded-sm hover:bg-blue-700";

      
        nextYearBtn.disabled = selectedYear === currentYear + 1;
        nextYearBtn.className = selectedYear === currentYear + 1
            ? "px-2 py-0 bg-gray-300 text-gray-500 rounded-sm cursor-not-allowed"
            : "px-2 py-0 bg-blue-500 text-white rounded-sm hover:bg-blue-700";
    }

    document.getElementById("prevYearBtn").addEventListener("click", () => {
        if (selectedYear > currentYear) {
            selectedYear--;
            updateYearSelector();
            check_available();
        }
    });

    document.getElementById("nextYearBtn").addEventListener("click", () => {
        if (selectedYear < currentYear + 1) {
            selectedYear++;
            updateYearSelector();
            check_available();
        }
    });

    let selectedMonth = null;
    let formattedMonth;

    function selectMonth(month) {
        document.querySelectorAll('[data-month]').forEach(btn => {
            btn.classList.remove('bg-teal-300', 'hover:bg-teal-500');
            btn.classList.add('bg-blue-500', 'hover:bg-blue-700');
        });

        let selectedBtn = document.querySelector(`[data-month="${month}"]`);
        selectedBtn.classList.remove('bg-blue-500', 'hover:bg-blue-700');
        selectedBtn.classList.add('bg-teal-300', 'hover:bg-teal-500');
        
        selected_room_id = selectedBtn.getAttribute('data-room-id');

        selectedMonth = month;
    
        formattedMonth = `${selectedYear}-${String(selectedMonth).padStart(2, "0")}`;
    }

    async function check_available() {
        try {
            let room_id = {{$room->id}};
            const response = await axios.get(`/student/api/reservation_slot/year/${room_id}/${selectedYear}`);
            console.log(response.data);

            response.data.forEach(item => {
                let monthBtn = document.querySelector(`[data-month="${item.month}"]`);
                if (!item.available) {
                    monthBtn.classList.remove('bg-blue-500', 'hover:bg-blue-700', 'cursor-pointer');
                    monthBtn.classList.add('bg-red-500', 'cursor-not-allowed');
                    monthBtn.disabled = true;
                }else{
                    monthBtn.setAttribute('data-room-id', item.id);
                }
            });
        } catch (error) {
            console.log(error);
        }
    }

    function data_store() {
        const month = document.getElementById('month');
        const i_month = document.querySelector('[name="date"]');
        const room_id = document.getElementById('roomID');


        room_id.value = selected_room_id;

        month.textContent = formattedMonth;
        i_month.value = formattedMonth;

        console.log( i_month.value )
 
        document.getElementById('close_model').click();

    }


</script>
