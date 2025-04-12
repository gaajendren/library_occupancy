<x-staff-app-layout>

    <style>
        /* Left column (dates) */
        .fc-resource-timeline th[data-resource-id] {
            width: 120px; /* Fixed width for dates */
            background: #f8f9fa;
        }
    
        .date-label {
            padding: 8px;
            text-align: center;
        }
    
        .day-name {
            font-weight: bold;
            color: #2c3e50;
        }
    
        .date {
            color: #7f8c8d;
        }
    
        /* Top header (time slots) */
        .fc-timeline-header {
            background: #f8f9fa;
        }
        .fc-event-title{
            color: black !important;
        }
        .fc-past-day{
            background: rgb(229, 231, 235);
        }
        .fc-event-start{
            display: flex;
            justify-content: center;
            align-items: center;
            border: none;
            padding: 5px;
            background-color: aqua !important;
        }
    </style>

    <main class="min-h-screen bg-slate-100 py-14 max-sm:px-5">
        <!-- Messages Section -->
        <div class="mx-8 mb-2">
            @include('staff.message.success')
            @include('staff.message.error')
        </div>

        <div class="max-w-2xl mx-auto">

            <div class="w-full flex justify-end items-end flex-col p-4 mb-2">
                <div class="w-fit rounded-lg shadow-md bg-white flex flex-row p-1 justify-center items-center ">
                    <button id="btn_table" class="cursor-pointer btn-switch bg-none p-1 px-2  hover:bg-gray-200 hover:rounded-lg" onclick="table()"><i class="fa-solid fa-table-columns text-gray-600 fa-sm"></i></button>
                    <div class="self-stretch w-px bg-gray-300 mx-1"></div>
                    <button id="btn_calender" class="cursor-pointer btn-switch bg-none p-1 px-2  hover:bg-gray-200 hover:rounded-lg" onclick="calender()"><i class="fa-regular fa-calendar-days text-gray-600 fa-sm"></i></button>
                </div>
            </div>



            <div id="table_container" class="hidden mx-8 bg-white rounded-lg shadow-lg border border-gray-300">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-400 bg-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Closing Time</h2>
                    <button onclick="document.getElementById('add_model').click()" class="bg-gray-800 text-white px-4 py-2 text-sm rounded-md hover:bg-gray-900 transition-colors shadow-sm">
                        + Add
                    </button>
                </div>

                <div class="p-4">
                    <div class="border border-gray-300 rounded-lg overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-100 border-b border-gray-300">
                                <tr>
                                    <th class="px-5 py-3 text-sm font-semibold text-gray-800 text-center border-r border-gray-300">Date</th>
                                    <th class="px-5 py-3 text-sm font-semibold text-gray-800 text-center border-r border-gray-300">Reason</th>
                                    <th class="px-5 py-3 text-sm font-semibold text-gray-800 text-center">Actions</th>
                                </tr>
                            </thead>
            
                            <tbody id="rows" class="divide-y divide-gray-300">
                            
                            
                            
                            </tbody>
                        </table>
                    </div>
                
                </div>
            </div>
       
            <div id="calendar" class="hidden" style="margin: 20px;"></div>
        </div>

   
    </main>

    @include('staff.reservation_management.add_holiday')
    @include('staff.reservation_management.edit_holiday')


    <script src='https://cdn.jsdelivr.net/npm/moment@2.29.4/min/moment.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/moment-timezone@0.5.40/builds/moment-timezone-with-data.min.js'></script>
    
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>

    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/moment-timezone@6.1.17/index.global.min.js'></script>

    <script>

    document.addEventListener('DOMContentLoaded', function() {
        calender()

        document.getElementById('btn_close').addEventListener('click', (btn)=>{
            document.getElementById('date').value = "";
            document.getElementById('description').value  = "";
        })
    });


    function insert_holiday(info){

       const btn_model = document.getElementById('add_model');
       document.getElementById('date').value = info.dateStr;
       document.getElementById('date_container').classList.add('hidden')
       btn_model.click();
    }


    function submit(e){

      e.preventDefault();
      
      const reason =  document.getElementById('description').value;
      const date  = document.getElementById('date').value;
      console.log(date, reason); 

        axios.post('/staff/add_holiday', {
            date: date,
            reason: reason
        }, {
            headers: {
                'Content-Type': 'application/json', 
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response =>{
            console.log(response)
            if(response.data.success){
                document.getElementById('btn_close').click()
                if(table_container.classList.contains('hidden')){
                    calender()
                }else{
                    table()
                }
            }
        })
        .catch(error => console.error(error));
    }

    async function get_data(){
        const response = await axios.get('/staff/get_holiday');

        if(response){
            console.log(response.data)
            draw_calender(response.data)
        }
    }

   function draw_calender(holidays){

        console.log(holidays)

        var calendarEl = document.getElementById('calendar');

        document.getElementById('table_container').classList.add('hidden')

        calendarEl.classList.remove('hidden');

      

        const calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'Asia/Kuala_Lumpur',
            selectable: true,
            selectAllow: function(selectInfo) {
                return selectInfo.start > new Date();
            } ,validRange: function(nowDate) {
                    return {
                        start: new Date(nowDate.getTime() + 24 * 60 * 60 * 1000) 
                    };
                },
            selectMirror: true,
            initialView: 'dayGridMonth',
            dateClick: function(info) {
                const eventsOnDate = calendar.getEvents().filter(event => {
                    const eventStart = event.start;
                    return eventStart && 
                        eventStart.getDate() === info.date.getDate() &&
                        eventStart.getMonth() === info.date.getMonth() &&
                        eventStart.getFullYear() === info.date.getFullYear();
                });

            
                if (eventsOnDate.length > 0) {
                    alert("This date already has an event!");
                    return;
                }
                if (info.date < new Date()) {   
                    alert("Cannot add holidays for past dates");               
                    return; 
                } else {
                    insert_holiday(info);
                }
            },
            
                events: holidays,
                eventTextColor: 'red'
        });

        calendar.render();

    }

    


    function table(){
        document.querySelectorAll('.btn-switch').forEach(element => {
            element.classList.remove('bg-gray-200')
            element.classList.add('bg-none')
        });

        document.getElementById('btn_table').classList.add('bg-gray-200');

        document.getElementById('calendar').classList.add('hidden')

        document.getElementById('table_container').classList.remove('hidden')

        axios.get('/staff/table/get_holiday')
        .then(response =>{
            draw_table(response.data)
        })
        .catch(error => console.log(error))


    }


    function draw_table(res){

        const row_container = document.getElementById('rows');

        row_container.innerHTML = ''

        document.getElementById('date').value = "";
        document.getElementById('date_container').classList.remove('hidden')

        res.forEach(data =>{
           

            const tr = document.createElement('tr');
            tr.classList.add('hover:bg-gray-100', 'transition-colors')

            tr.innerHTML = `
            <td class="px-5 py-4 text-sm text-gray-700 text-center font-medium border-r border-gray-200">
               ${data.date}
            </td>
            
            <td class="px-5 py-4 text-sm text-gray-800 text-center font-medium border-r border-gray-200">
                ${data.reason}
            </td>
            <td class="px-5 py-4 text-center">
                <div class="flex justify-center gap-2">
                    <button onclick="delete_data(${data.id})"  class="p-2 text-gray-700 hover:text-gray-900 rounded-md hover:bg-gray-200 transition-colors">
                       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                       </svg>
                    </button>
                    <button onclick="edit_model_data( ${data.id},  '${data.date}', '${data.reason}')" class="p-2 text-blue-700 hover:text-blue-900 rounded-md hover:bg-blue-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </button>
                </div>
            </td>`

            row_container.append(tr);
        })
     
    }

    function delete_data(id){
       const result = confirm('Confirm delete ?');

       if(result){
         axios.delete(`/staff/delete_holiday/${id}`)
         .then( response =>{
            if (response.data.success){
                table()
            }
            console.log(response)
           
        }).catch(error => console.log(error))
       }
    }

    function edit_model_data(id, date, reason){
        document.getElementById('btn_edit_modal').click();
        document.getElementById('btn_update').setAttribute('data-id', `${id}`)

        document.getElementById('edit_description').value = reason
        document.getElementById('edit_date').value = date

    }
    
    function calender(){
        document.querySelectorAll('.btn-switch').forEach(element => {
            element.classList.remove('bg-gray-200')
            element.classList.add('bg-none')
        });

        document.getElementById('btn_calender').classList.add('bg-gray-200');
        get_data()
    }

    function update(e){
        e.preventDefault();

        const id = e.target.getAttribute('data-id');

        const reason = document.getElementById('edit_description').value 
        const date = document.getElementById('edit_date').value 
        
        axios.patch(`/staff/update_holiday?id=1`,{
            reason: reason,
            date: date
        })
        .then( response =>{
            if (response.data.success){
                document.getElementById('edit_btn_close').click();
                table()
            } 
           
        }).catch(error => console.log(error))
    }


    </script>
</x-staff-app-layout>